<?php

class users_db {
    public static function GetUsersQuery($where="")
    {
        $sql ="select * from users u left join user_types ut on u.user_type=ut.id [{where}] order by added_date desc";
	if($where!="") $sql=str_replace("[{where}]" ,$where, $sql);

        return $sql;
    }

    public static function GetImportedUsersQuery()
    {
        $sql ="select * from v_imported_users order by name,surname";
        return $sql;
    }
}
?>
