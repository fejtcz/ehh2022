<?php

/*
 * Trida pro praci s Firebird databazi
 *
 * @author  Lubomir Sedlacek <lubosse@gmail.com>
 * @author  Martin Fejt <martin@fejt.cz>
 * @version 20220805
 */

class Database
{
    public $throw = 0;
    private $dbhandler;

    public function __construct($connection)
    {
        $this->dbhandler = @ibase_connect($connection["DB_HOST"], $connection["DB_USER"], $connection["DB_PASS"], $connection["DB_CHARSET"], null, null, $connection["DB_ROLE"]) or trigger_error('DB error: ' . ibase_errmsg(), E_USER_ERROR);
    }

    public function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * Metoda, ktera vraci vsechny vysledky SQL dotazu jako asociovane pole
     * @param   string  $query  SQL Dotaz
     * @return  array
     */
    public function QueryFetchAllAssoc($query)
    {
        $ds = $this->QueryDataSet($query);
        if ($ds) {
            $return = array();
            while ($res = $this->FetchAssoc($ds)) {
                $return[] = $res;
            }
            $this->FreeDataSet($ds);
            return $return;
        } else {
            return false;
        }
    }

    /**
     * Metoda pro osetreni vstupniho stringu proti SQL inject utoku
     * @param   string  $string  Vstupni retezec ke zpracovani
     * @return  string
     */
    public function SqlInjectProtection($string)
    {
        $string = htmlspecialchars($string);
        $string = str_replace("'", "x", $string);
        $string = str_replace("`", "x", $string);
        return $string;
    }

    /**
     * Metoda, ktera zajisti spusteni SQL dotazu na serveru
     * @param   string  @query  SQL Dotaz
     * @return  resource
     */
    private function QueryDataSet($query)
    {
        $ret = @ibase_query($this->dbhandler, $query);
        if ($ret === false) {
            trigger_error('DB Query error: ' . ibase_errmsg() . "<br />" . $query, E_USER_WARNING);
            if ($this->throw) {
                throw new Exception('DB Query error: ' . ibase_errmsg());
            }

        }
        return $ret;
    }

    /**
     * Drobne podpurne DB metody
     */
    private function FetchAssoc($ds)
    {
        return ibase_fetch_assoc($ds, IBASE_TEXT || IBASE_UNIXTIME);
    }

    private function FreeDataSet($ds)
    {
        return ibase_free_result($ds);
    }

    public function Exec(string $query)
    {
        return ibase_query($this->dbhandler, $query);
    }

    public function RollBack()
    {
        return ibase_rollback($this->dbhandler);
    }

    private function Disconnect()
    {
        @ibase_close($this->dbhandler);
    }
}
