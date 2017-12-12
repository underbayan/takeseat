<?php
include_once("./config.php"); //change config_template
class dm
{
    private $dbcnn;

    function __construct()
    {
        $this->dbcnn = @mysql_pconnect(ADDR, USER, PWD);
        if (!$this->dbcnn)
            $this->dbcnn = @mysql_connect(ADDR, USER, PWD);
        if ($this->dbcnn) @mysql_select_db(DATABASE, $this->dbcnn);
        $this->query("SET NAMES " . CHARSET);
        // if (mysql_errno ()){echo mysql_errno ();exit(1);}

        register_shutdown_function(array(& $this, '__destruct'));
    }

    function __destruct()
    {
        if (!$this->dbcnn)
            mysql_close($this->dbcnn);
    }

    function query($sql)
    {
        return mysql_query($sql, $this->dbcnn);
    }

    function exec($sql)
    {
        return mysql_query($sql, $this->dbcnn);
    }

    function showError($l)
    {
        printf($l . "::%d:Mysql Query Failed: %s\n<br/>", mysql_errno($this->dbcnn), mysql_error($this->dbcnn));
    }

    public function getAllSeat()
    {
        if (!$ret = $this->query("select * from seat"))
            $this->showError(__LINE__);
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function deleteSeat($id)
    {
        $id = mysql_escape_string($id);
        if (@$ret = $this->exec("delete from seat where id='$id';")) ;
        return $ret;
    }

    public function addSeat($layer, $px, $py, $w, $h)
    {
        $layer = mysql_escape_string($layer);
        $px = mysql_escape_string($px);
        $py = mysql_escape_string($py);
        $w = mysql_escape_string($w);
        $h = mysql_escape_string($h);
        if (!$ret = $this->exec("insert into seat (layer,px,py,w,h) values($layer,$px,$py,$w,$h);"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function setSeat($id, $owner, $status)
    {
        $id = mysql_escape_string($id);
        $owner = mysql_escape_string($owner);
        $status = mysql_escape_string($status);
        $ret = $this->exec("update seat set owner ='$owner',status='$status' where id='$id';");
        if ($owner != '') {
            $this->exec("update user set status =1 where name='$owner';");
        }
        if (!$ret)
            $this->showError(__LINE__);
        return $ret;
    }

    public function removeOwnerSeat($name)
    {
        $name = mysql_escape_string($name);
        $this->exec("update user set status=0 where name='$name'");
        if (!$ret = $this->exec("update seat set owner ='',status=0 where owner='$name' and status<>2;"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function resetAllSeat()
    {
        $this->exec("update user set status=0;");
        if (!$ret = $this->exec("update seat set owner ='',status=0 where status<>2;"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function forceRandDisSeat()
    {
        $this->resetAllSeat();
        $seat = array();
        $ret = $this->query("select * from seat where status<2;");
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($seat, $row);
        }
        $user = $this->getAllUser();
        $sl = count($seat);
        $ul = count($user);
        if ($sl == 0 && $ul == 0)
            return;
        shuffle($user);
        shuffle($seat);
        if ($sl >= $ul)
            $l = $ul;
        else
            $l = $sl;
        $sql = '';
        for ($tmpi = 0; $tmpi < $l; $tmpi++) {
            $status = ($seat[$tmpi]['status'] == 0) + 0;
            $name = $user[$tmpi]['name'];
            $id = $seat[$tmpi]['id'];
            $this->exec("update seat set owner='$name',status=1 where id='$id'; ");
            $this->exec("update user set status=1 where name='$name';");
        }
        return 1;
    }

    public function randDisSeat()
    {
        $seat = array();
        $user = array();
        $ret = $this->query("select * from seat where status=0;");
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($seat, $row);
        }
        $ret = $this->query("select * from user where status=0;");
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($user, $row);
        }
        $sl = count($seat);
        $ul = count($user);
        if ($sl == 0 || $ul == 0)
            return 0;
        shuffle($user);
        shuffle($seat);
        if ($sl >= $ul)
            $l = $ul;
        else
            $l = $sl;
        $sql = '';
        for ($tmpi = 0; $tmpi < $l; $tmpi++) {
            $name = $user[$tmpi]['name'];
            $id = $seat[$tmpi]['id'];
            $this->exec("update seat set owner='$name',status=1 where id='$id'; ");
            $this->exec("update user set status=1 where name='$name';");
        }
        echo 1;
    }

    public function clearSeat()
    {
        if (!$ret = $this->exec($this->sql['delete_seat']))
            $this->showError(__LINE__);
        return $ret;
    }

    // user
    public function getAllUser()
    {
        if (!$ret = $this->query("select * from user;"))
            $this->showError(__LINE__);
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function changeUserPwd($oldpwd, $pwd, $pwd2)
    {
        if ($pwd2 != $pwd) {
            return "两次密码不匹�&#65533;";
        }

        $id = $_SESSION['_userId'];
        if ($id != 0 && $id == null)
            return "请登�&#65533;";
        $oldpwd = md5(mysql_escape_string($oldpwd) . '___salt___');
        $ret = $this->query("select pwd from user where id='$id';");
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        if ($oldpwd != $result[0]['pwd']) {
            return "旧密码错�&#65533;";
        }
        $pwd = md5(mysql_escape_string($pwd) . '___salt___');
        if ($id != null || $id == 0) {
            $ret = $this->exec("update user set pwd='$pwd' where id='$id'; ");
        }
        return $ret;
    }

    public function getUserByName($name)
    {
        $name = mysql_escape_string($name);
        if (!$ret = $this->query("select * from user where name='$name';"))
            $this->showError(__LINE__);
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function setUser($id, $name, $status)
    {
        $name = mysql_escape_string($name);
        $id = mysql_escape_string($id);
        $status = mysql_escape_string($status);
        if (!$ret = $this->exec("update user set name='$name' status='$status' where id='$id';"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function addUser($name)
    {
        $name = mysql_escape_string($name);
        $newpwd = md5("12345678" . "___salt___");
        if (!$ret = $this->exec("insert into user (name,status,type,pwd) values('$name',0,0,'$newpwd');"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function deleteUser($id)
    {
        $id = mysql_escape_string($id);
        if (!$ret = $this->exec("delete from user where id='$id';"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function resetUserPwd($id)

    {
        $id = mysql_escape_string($id);
        $newpwd = md5("12345678" . "___salt___");
        if (!$ret = $this->exec("update user set pwd='$newpwd' where id='$id';"))
            $this->showError(__LINE__);
        return $ret;
    }

    // config
    public function getConfig()
    {
        if (!$ret = $this->query("select * from config;"))
            $this->showError(__LINE__);
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function setConfig($id, $value)
    {
        $id = mysql_escape_string($id);
        $value = mysql_escape_string($value);
        if (!$ret = $this->exec("update config set value='$value' where id='$id';"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function setConfigByName($name, $value)
    {
        $name = mysql_escape_string($name);
        $value = mysql_escape_string($value);
        if (!$ret = $this->exec("update config set value='$value' where name='$name';"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function changeAdminPwd($oldpwd, $pwd, $pwd2)
    {
        if ($pwd2 != $pwd) {
            return "两次密码不匹�&#65533;";
        }
        if ($_SESSION['type'] != 'admin')
            return "请登录为管理�&#65533;";
        $oldpwd = md5(mysql_escape_string($oldpwd) . '___salt___');
        $c = $this->getConfig();
        foreach ($c as $t) {
            switch ($t['name']) {
                case 'adminpwd': {
                    $sqlpwd = $t['value'];
                    break;
                }
            }
        }
        if ($sqlpwd != $oldpwd) {
            return "旧密码错�&#65533;";
        }
        $pwd = md5(mysql_escape_string($pwd) . '___salt___');
        return $ret = $this->exec("update config set value='$pwd' where name='adminpwd'; ");
    }

    public function getLayer($id)
    {
        $id = mysql_escape_string($id);
        if (!$ret = $this->query($this->sql["select * from where id='$id';"]))
            $this->showError(__LINE__);
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function getAllLayer()
    {
        if (!$ret = $this->query('select * from layer;'))
            $this->showError(__LINE__);
        $result = array();
        while (@$row = mysql_fetch_assoc($ret)) {
            array_push($result, $row);
        }
        return $result;
    }

    public function addLayer($p)
    {
        $p = mysql_escape_string($p);
        if (!$ret = $this->exec("insert into layer (imagePath) values('$p');"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function deleteLayer($id)
    {
        $id = mysql_escape_string($id);
        $ret = $this->exec("delete from  seat where layer='$id';");
        if (!$ret = $this->exec("delete from  layer where id='$id';"))
            $this->showError(__LINE__);
        return $ret;
    }

    public function updateLayer($path, $id)
    {
        $id = mysql_escape_string($id);
        $path = mysql_escape_string($path);
        if (!$ret = $this->exec("update layer set imagePath='$path' where id='$id';"))
            $this->showError(__LINE__);
        return $ret;
    }

}
