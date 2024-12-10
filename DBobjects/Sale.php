<?php
class Sale {
    private $db;
    private $session;

    public function __construct($db, $session) {
        $this->db = $db;
        $this->session = $session;
    }

    /**
     * Add a new sale record
     */
    public function addSale($data) {
        $errors = $this->validateSale($data);

        if (!empty($errors)) {
            $this->session->msg("d", $errors);
            return false;
        }

        $p_id    = $this->db->escape((int)$data['s_id']);
        $s_qty   = $this->db->escape((int)$data['quantity']);
        $s_total = $this->db->escape($data['total']);
        $s_date  = make_date(); // Current date

        $query  = "INSERT INTO sales (product_id, qty, price, date) ";
        $query .= "VALUES ('{$p_id}', '{$s_qty}', '{$s_total}', '{$s_date}')";

        if ($this->db->query($query)) {
            $this->updateProductQuantity($s_qty, $p_id);
            $this->session->msg('s', "Sale added successfully.");
            return true;
        } else {
            $this->session->msg('d', "Failed to add sale.");
            return false;
        }
    }

    /**
     * Validate required fields for sale
     */
    private function validateSale($data) {
        $errors = [];
        $required_fields = ['s_id', 'quantity', 'price', 'total'];

        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Field '{$field}' cannot be blank.";
            }
        }

        return $errors;
    }

    /**
     * Update product quantity after sale
     */
    private function updateProductQuantity($quantity_sold, $product_id) {
        $sql = "UPDATE products SET quantity = quantity - {$quantity_sold} WHERE id = {$product_id}";
        return $this->db->query($sql);
    }
}
?>
