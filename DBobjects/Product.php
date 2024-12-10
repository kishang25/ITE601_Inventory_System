<?php
class Product {
    private $db;
    private $session;

    public function __construct($db, $session) {
        $this->db = $db;
        $this->session = $session;
    }

    public function addProduct($data) {
        $errors = $this->validateProduct($data);

        if (!empty($errors)) {
            $this->session->msg("d", $errors);
            return false;
        }

        $p_name  = remove_junk($this->db->escape($data['product-title']));
        $p_cat   = remove_junk($this->db->escape($data['product-categorie']));
        $p_qty   = remove_junk($this->db->escape($data['product-quantity']));
        $p_buy   = remove_junk($this->db->escape($data['buying-price']));
        $p_sale  = remove_junk($this->db->escape($data['saleing-price']));
        $media_id = isset($data['product-photo']) && $data['product-photo'] !== "" ? remove_junk($this->db->escape($data['product-photo'])) : '0';
        $date    = make_date();

        $query = "INSERT INTO products (name, quantity, buy_price, sale_price, categorie_id, media_id, date) ";
        $query .= "VALUES ('{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}') ";
        $query .= "ON DUPLICATE KEY UPDATE name='{$p_name}'";

        if ($this->db->query($query)) {
            $this->session->msg('s', "Product added successfully.");
            return true;
        } else {
            $this->session->msg('d', "Sorry, failed to add product.");
            return false;
        }
    }

    private function validateProduct($data) {
        $errors = [];
        $required_fields = ['product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price'];

        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Field '{$field}' cannot be blank.";
            }
        }

        return $errors;
    }

    public function getAllCategories() {
        return find_all('categories');
    }

    public function getAllPhotos() {
        return find_all('media');
    }
}
?>
