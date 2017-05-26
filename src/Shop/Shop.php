<?php

namespace Alvo16\Shop;

class Shop implements \Anax\Common\AppInjectableInterface
{
    use \Anax\Common\AppInjectableTrait;

    public function getColumnNames($db = 'oophp', $table = 'stock')
    {
        $sql = "SELECT `COLUMN_NAME`
        FROM `INFORMATION_SCHEMA`.`COLUMNS`
        WHERE `TABLE_SCHEMA`='$db'
            AND `TABLE_NAME`='$table';";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        return $res;
    }

    public function getStockData()
    {
        $sql = "select * from VgetStock";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        if ($res) {
            return $res;
        } else {
            throw new \Exception("Stock is empty!", 1);
        }
    }

    public function getStockDataById($id)
    {
        $sql = "select * from VgetStock where `id` = '$id'";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        if ($res) {
            return $res;
        } else {
            throw new \Exception("Stock is empty!", 1);
        }
    }

    public function updateData($data)
    {
        // var_dump($data);
        // exit;
        $sql = "update `stock`
        set
            description='{$data['description']}',
            img='{$data['img']}',
            category='{$data['category']}',
            price='{$data['price']}',
            quantity='{$data['quantity']}'
        WHERE
            id='{$data['id']}'";

        $this->app->db->connect();
        $this->app->db->execute($sql);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `stock` WHERE id = '$id'";

        $this->app->db->connect();
        $this->app->db->execute($sql);
    }

    public function add($data)
    {
        $sql = "INSERT INTO stock
        VALUES
            (
                null,
                '{$data['description']}',
                '{$data['img']}',
                '{$data['category']}',
                '{$data['price']}',
                '{$data['quantity']}'
            )";

        $this->app->db->connect();
        $this->app->db->execute($sql);
    }

    public function getCart()
    {
        $sql = "SELECT * FROM VgetCart";

        $res = $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        if ($res) {
            return $res;
        } else {
            return [];
        }
    }

    public function addToCart($id)
    {
        $sql = "CALL addToCart($id)";

        $this->app->db->connect();
        $this->app->db->execute($sql);
    }

    public function deleteFromCart($id)
    {
        $sql = "DELETE FROM `cart` WHERE id = '$id'";

        $this->app->db->connect();
        $this->app->db->execute($sql);
    }

    public function doOrder()
    {
        $cart = self::getCart();

        $this->app->db->connect();

        foreach ($cart as $row) {
            $sql = "call doOrder($row->stockId)";
            $this->app->db->execute($sql);
        }
    }

    public function getOrderDetails()
    {
        self::doOrder();

        $sql = "select * from VgetCheckoutDetails";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        if ($res) {
            return $res;
        } else {
            var_dump($res);
            return [];
        }
    }
}
