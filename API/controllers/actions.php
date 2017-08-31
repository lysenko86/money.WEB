<?php
class Actions{
    function getActions($params, &$data, &$db){
        $data['arr'] = $db->query("
            SELECT
                `a`.*,
                DATE_FORMAT(`a`.`date`, '%d.%m.%Y') AS `date`,
                IFNULL(`a1`.`title`, 'Рахунок видалений') AS `accountFrom_title`,
                IFNULL(`a2`.`title`, 'Рахунок видалений') AS `accountTo_title`,
                IFNULL(`c`.`title`, 'Категорія видалена') AS `category_title`
            FROM `actions` AS `a`
                LEFT JOIN `accounts` AS `a1` ON (`a1`.`id` = `a`.`accountFrom_id`)
                LEFT JOIN `accounts` AS `a2` ON (`a2`.`id` = `a`.`accountTo_id`)
                LEFT JOIN `categories` AS `c` ON (`c`.`id` = `a`.`category_id`)
            WHERE `a`.`uid` = ?
            ORDER BY `a`.`date` DESC, `a`.`id` DESC
            LIMIT ?,?
        ", array($params['uid'], $params['from'], $params['count']), false);
        $data['status'] = 'success';
    }
}
?>
