<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2009, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2009
 * @version $Id$
 */
class Install_Controller extends Template_Controller {

    public function index()
    {
        $dbuser='';
        $dbpass='';
        $dbhost='';
        $dbdatabase='';
        if($_POST)
        {
            echo Kohana::debug($this->input->post());
            $dbuser=$_POST['dbuser'];
            $dbpass=$_POST['dbpass'];
            $dbhost=$_POST['dbhost'];
            $dbdatabase= $_POST['dbdatabase'];
        }
            
            $this->template->dberror="";
            
            $config = array
            (
                'benchmark'     => FALSE,
                'persistent'    => FALSE,
                'connection'    => array
                (
                    'type'     => 'mysql',
                    'user'     => 'bla',
                    'pass'     => 'fsadfsadf',
                    'host'     => 'jo',
                    'port'     => FALSE,
                    'socket'   => FALSE,
                    'database' => 'test'
                ),
                'character_set' => 'utf8',
                'table_prefix'  => '<?php echo $table_prefix ?>',
                'object'        => TRUE,
                'cache'         => TRUE,
                'escape'        => TRUE
            );
            
            try
            {
                $this->check_mysql($dbhost, $dbdatabase, $dbuser, $dbpass);
                
                echo "db ok";
                // weiter gehts, alles ok
            } 
            catch (Exception $e)
            {
                echo "db not ok";
                $this->template->dberror =$e->getMessage();
            }

    }
    
    
    private function check_mysql($host, $database, $username, $password) {
                $link = @mysql_connect($host, $username, $password);
                if(!$link) {
                        $error = '';
                        
                        if(strpos(mysql_error(), 'Access denied') !== false) {
                                $error = 'wrong username or password';
                        } elseif(strpos(mysql_error(), 'server host') !== false) {
                                $error = 'unknown host: '.$host;
                        } elseif(strpos(mysql_error(), 'connect to') !== false) {
                                $error = 'Can\'t connect to host: '.$host;
                        }else {
                                $error = mysql_error();
                        }
                        
                        throw new Exception($error);
                        return $error;
                }
                
                $select = mysql_select_db($database, $link);
                if (!$select) {
                    throw new Exception(mysql_error());
                        return mysql_error();
                }
                
                return true;
        }

}



