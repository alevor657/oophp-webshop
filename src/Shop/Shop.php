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
        $sortSuffix = self::getSortingSuffix();
        $searchSuffix = self::getSearchSuffix();
        $limit = self::getLimit();
        $sql = "select * from VgetStock" . ' ' . $searchSuffix . ' ' . $sortSuffix . ' ' . $limit;
        // exit;

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
        $this->app->db->connect();

        $sql = "call doOrder({$this->app->users->getCurrentUserId()});";
        $this->app->db->execute($sql);
    }

    public function getOrderDetails($orderId = null)
    {
        if (!$orderId) {
            $userId = $this->app->users->getCurrentUserId();

            $sql = "select max(id) as `order_id` from orders where user_id = $userId ";

            $this->app->db->connect();
            $orderId = $this->app->db->executeFetchAll($sql)[0]->order_id;
        }

        $sql = "call getOrderDetails($orderId);";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        if ($res) {
            return $res;
        } else {
            // var_dump($res);
            return [];
        }
    }

    private function getSortingSuffix()
    {
        // $suffix = isset($_GET['sort']) ? $_GET['sort'] : ;
        if (isset($_GET['sort'])) {
            return $suffix = "ORDER BY {$_GET['sort']} ASC";
        } else {
            return $suffix = "ORDER BY id ASC";
        }
    }

    private function getSearchSuffix()
    {
        if (isset($_GET['search'])) {
            return "WHERE description LIKE '%{$_GET['search']}%'";
        } else {
            return '';
        }
    }

    private function getLimit()
    {
        if (isset($_GET['limit'])) {
            return "LIMIT {$_GET['limit']}";
        } else {
            return '';
        }
    }

    private function getCurrentUserOrdersIds()
    {
        $curId = $this->app->users->getCurrentUserId();
        $sql = "select id from orders where user_id = $curId";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);
        // var_dump($res);
        // exit;

        return $res;
    }

    public function getOrderHistory()
    {
        $res = [];
        $orderIds = self::getCurrentUserOrdersIds();
        // var_dump($orderIds);
        // exit;

        foreach ($orderIds as $id) {
            if (!empty($id)) {
                $res[] = self::getOrderDetails($id->id);
            }
        }

        return $res;
    }
}
