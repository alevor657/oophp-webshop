<?php

namespace Alvo16\Content;

class Content implements \Anax\Common\AppInjectableInterface
{
    use \Anax\Common\AppInjectableTrait;

    // public function getColumnNames($db = 'oophp', $table = 'content')
    // {
    //     $sql = "SELECT `COLUMN_NAME`
    //     FROM `INFORMATION_SCHEMA`.`COLUMNS`
    //     WHERE `TABLE_SCHEMA`='$db'
    //         AND `TABLE_NAME`='$table';";
    //
    //     return $this->app->db->executeFetchAll($sql);
    // }

    public function getBlogData($route = null)
    {
        if (!$route) {
            $sql = <<<EOD
        SELECT * FROM `content` WHERE `type` = 'post';
EOD;
        } else {
            $sql = <<<EOD
            SELECT * FROM `content` WHERE `type` = 'post' AND `slug` = '$route';
EOD;
        }

        $this->app->db->connect();
        $data = $this->app->db->executeFetchAll($sql);

        if (!$data) {
            $this->app->response->redirect($this->app->url->create('404'));
        }

        return $data;
    }



    public function getBlockData()
    {
        // if (!$id) {
            $sql = <<<EOD
        SELECT * FROM content WHERE type = 'block' LIMIT 1
EOD;
        // } else {
//             $sql = <<<EOD
//             SELECT * FROM content WHERE type = 'block' AND id = '$id'
// EOD;
        // }

        $this->app->db->connect();
        $data = $this->app->db->executeFetchAll($sql);

        if (!$data) {
            return null;
        }

        return $data[0];
    }



    public function getData($id = null)
    {
        if (!$id) {
            $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
;
EOD;
        } else {
            $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE `id` = '$id'
;
EOD;
        }
        $this->app->db->connect();
        return $this->app->db->executeFetchAll($sql);
    }

    public function updateContent($data)
    {
        // if (!self::checkSlug($data['slug'])) {
        //     var_dump("Given slug exists!");
        //     var_dump($data['slug']);
        // }

        self::checkSlug($data);

        $sql = "UPDATE content
        SET
            title=?,
            type=?,
            path=?,
            slug=?,
            filter=?,
            published=?,
            deleted=?,
            data=?
        WHERE id=?";

        // var_dump($sql);
        // var_dump($data);
        if (!$data['slug']) {
            $data['slug'] = slugify($data['title']);
        }

        if (!$data['deleted']) {
            $data['deleted'] = null;
        }

        $this->app->db->connect();
        $this->app->db->execute($sql, array_values($data));
    }

    public function add($data)
    {
        // if (!self::checkSlug($data['slug'])) {
        //     var_dump("Given slug exists!");
        //     var_dump($data['slug']);
        //     exit;
        // }

        self::checkSlug($data);

        // if (!$data['formPath']) {
        //     $data['formPath'] = null;
        // }
        foreach (array_values($data) as $value) {
            if ($value == "") {
                $value = null;
            }
        }

        // var_dump($data);
        // exit;

        if (!$data['slug']) {
            $data['slug'] = slugify($data['title']);
        }

        $sql = "INSERT INTO content
        (
            title,
            type,
            path,
            slug,
            filter,
            published,
            data
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)";

        // var_dump($sql);
        // var_dump($data);
        // exit;

        $this->app->db->connect();
        $this->app->db->execute($sql, array_values($data));
    }

    public function delete($id)
    {
        // $sql = "DELETE FROM content WHERE `id` = '$id'";
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?";

        $this->app->db->connect();
        $this->app->db->execute($sql, [$id]);
    }

    public function purge($id)
    {
        // $sql = "DELETE FROM content WHERE `id` = '$id'";
        $sql = "DELETE FROM content WHERE id = ?";

        $this->app->db->connect();
        $this->app->db->execute($sql, [$id]);
    }

    public function getDataByPath($path)
    {
        $sql = <<<EOD
SELECT
   *,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
   DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
   path = ?
   AND type = ?
   AND (deleted IS NULL OR deleted > NOW())
   AND published <= NOW()
;
EOD;

        $this->app->db->connect();
        $data = $this->app->db->executeFetchAll($sql, [$path, 'page']);

        if (!$data) {
            $this->app->response->redirect($this->app->url->create('404'));
            // header("HTTP/1.0 404 Not Found");
        }

        return $data[0];
    }

    private function checkSlug($data)
    {
        $sql = "SELECT slug, title FROM content";

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql);

        $slug = $data['slug'];

        // var_dump($res);
        // echo PHP_EOL;
        // var_dump($data);
        // exit;

        foreach ($res as $elem) {
            if ($elem->slug === $slug) {
                $currentTitle = $data['title'];

                if ($elem->title != $currentTitle) {
                    throw new \Exception("Given slug exists!", 1);
                }
            }
        }

        return true;
    }
}
