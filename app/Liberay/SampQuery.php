<?php
/**
 * @author Edward McKnight (EM-Creations.co.uk)
 */

/* *****************************************************************
// SampQuery.class.php
// Version 1.1
// This class connects to a specific SA-MP server via sockets.
// Copyright 2014 Edward McKnight (EM-Creations.co.uk)
// Creative Commons Attribution-NoDerivs 3.0 Unported License
// http://creativecommons.org/licenses/by-nd/3.0/
// Credits to Westie for the original PHP SA-MP API and inspiration for this API.
* *****************************************************************/
namespace App\SAMP;

class SampQuery {
    private $sock = null;
    private $server = null;
    private $port = null;
	
    /**
     *	Creates a new SampQuery object.
     *	@param $server server hostname
     *	@param $port port of the server
     */
    
    
    public function __construct($server, $port=7777) {
		// <editor-fold defaultstate="collapsed" desc="Constructor">
        $this->server = $server;
        $this->port = $port;

        $this->sock = fsockopen("udp://".$this->server, $this->port, $errorNum, $errorString, 2);
        socket_set_timeout($this->sock,1);
		// </editor-fold>
    }

    /**
     * Returns an array of server information. 
     * @return Array[]
     * (
     *   [password] => 0 or 1
     *   [players] => players
     *   [maxplayers] => maxPlayers
     *   [hostname] => hostName
     *   [gamemode] => gamemode
     *   [map] => map
     * )
     */
    public function getOnlinePlayers()
    {
        @fwrite($this->sock, $this->assemblePacket("i"));
        fread($this->sock, 11);


        $playerInfo = array();
        
        ///??
        (integer) fread($this->sock, 1);

        $playerInfo['players'] = (integer) $this->toInt(fread($this->sock, 2));
        $playerInfo['maxplayers'] = (integer) $this->toInt(fread($this->sock, 2));
        return $playerInfo;
    }

    public function getInfo() {
		// <editor-fold defaultstate="collapsed" desc="Get Info">
        @fwrite($this->sock, $this->assemblePacket("i"));

        fread($this->sock, 11);

        $serverInfo = array();

        $serverInfo['password'] = (integer) ord(fread($this->sock, 1));

        $serverInfo['players'] = (integer) $this->toInt(fread($this->sock, 2));

        $serverInfo['maxplayers'] = (integer) $this->toInt(fread($this->sock, 2));

        $strLen = ord(fread($this->sock, 4));
        if(!$strLen) return -1;

        $serverInfo['hostname'] = (string) fread($this->sock, $strLen);

        $serverInfo['gamemode'] = "";
        $strLen = ord(fread($this->sock, 4));
        if($strLen) $serverInfo['gamemode'] = (string) fread($this->sock, $strLen);

        $serverInfo['map'] = "";
        $strLen = ord(fread($this->sock, 4));
        if($strLen) $serverInfo['map'] = (string) fread($this->sock, $strLen);
        //UTF8处理
        
        $serverInfo['gamemode'] = iconv("GBK","UTF-8//IGNORE",$serverInfo['gamemode']);
        $serverInfo['hostname'] = iconv("GBK","UTF-8//IGNORE",$serverInfo['hostname']);
        $serverInfo['map'] = iconv("GBK","UTF-8//IGNORE",$serverInfo['map']);
        //$serverInfo['hostname'] = utf8_encode($serverInfo['hostname']);
        
        //$serverInfo['gamemode'] = utf8_encode($serverInfo['gamemode']);
        //$serverInfo['map'] = utf8_encode($serverInfo['map']);
        return $serverInfo;
		// </editor-fold>
    }


    /**
     * Returns a multidimensional array of basic player information.
     * @return Array[]
     * (
     *   [0] => Array[]
     *       (
     *           [name] => playerName
     *           [score] => score
     *       )
     *	...
     * )
     * @see getDetailedPlayers()
     */
    public function getBasicPlayers() {
		// <editor-fold defaultstate="collapsed" desc="Get Basic Players">
        @fwrite($this->sock, $this->assemblePacket("c"));
        fread($this->sock, 11);

        $playerCount = ord(fread($this->sock, 2));
        $players = array();

        if($playerCount > 0) {
            for($i = 0; $i < $playerCount; ++$i) {
                $strLen = ord(fread($this->sock, 1));
                $players[$i] = array
                (
                    "name" => iconv("GBK","UTF-8//IGNORE",(string) fread($this->sock, $strLen)),
                    "score" => (integer) $this->toInt(fread($this->sock, 4)),
                );
            }
        }
        return $players;
		// </editor-fold>
    }


    /**
     * Returns a multidimensional array of detailed player information. 
     * @return Array[]
     * (
     *   [0] => Array
     *	(
     *       [playerid] => playerid
     *       [nickname] => playername
     *       [score] => score
     *       [ping] => pinh
     *	)
     *   ... 
     * )
     * @see getBasicPlayers()
     */
    public function getDetailedPlayers() {
		// <editor-fold defaultstate="collapsed" desc="Get Detailed Players">
        @fwrite($this->sock, $this->assemblePacket("d"));
        fread($this->sock, 11);

        $playerCount = ord(fread($this->sock, 2));
        $players = array();

        for($i = 0; $i < $playerCount; ++$i) {
            $player['playerid'] = (integer) ord(fread($this->sock, 1));

            $strLen = ord(fread($this->sock, 1));
            $player['nickname'] =  iconv("GBK","UTF-8//IGNORE",(string) fread($this->sock, $strLen) );

            $player['score'] = (integer) $this->toInt(fread($this->sock, 4));
            $player['ping'] = (integer) $this->toInt(fread($this->sock, 4));

            $players[$i] = $player;
            unset($player);
        }
        return $players;
		// </editor-fold>
    }


    /**
     * Returns an array of server rules.
     * @return Array[]
     * (
     *   [gravity] => gravity
     *   [mapname] => map
     *   [version] => version
     *   [weather] => weather
     *   [weburl] => weburl
     *   [worldtime] => worldtime
     * )
     */
    public function getRules() {
        // <editor-fold defaultstate="collapsed" desc="Get Rules">
        //iconv("GBK","UTF-8//IGNORE",(string) fread($this->sock, $strLen) );
        @fwrite($this->sock, $this->assemblePacket("r"));
        fread($this->sock, 11);

        $ruleCount = ord(fread($this->sock, 2));
        $rules = array();

        for($i = 0; $i< $ruleCount; ++$i) {
            $strLen = ord(fread($this->sock, 1));
            $rule = iconv("GBK","UTF-8//IGNORE",(string) fread($this->sock, $strLen) );

            $strLen = ord(fread($this->sock, 1));
            $rules[$rule] = iconv("GBK","UTF-8//IGNORE",(string) fread($this->sock, $strLen) );
        }
        return $rules;
		// </editor-fold>
    }
    
    /**
     * Returns the server's ping.
     * @return integer
     */
    public function getPing() {
		// <editor-fold defaultstate="collapsed" desc="Get Ping">
        $ping = 0;
        $beforeSend = microtime(true);
        @fwrite($this->sock, $this->assemblePacket("r"));
        fread($this->sock, 15);
        $afterReceive = microtime(true);
        
        $ping = ($afterReceive - $beforeSend) * 1000;
        
        return round($ping);
		// </editor-fold>
    }

	/**
	 * Converts a string to an integer
	 * 
	 * @param String $string
	 * @return int|null
	 */
    private function toInt($string) {
		// <editor-fold defaultstate="collapsed" desc="To Int">
        if($string === "") {
            return null;
        }

        $int = 0;
        $int += (ord($string[0]));

        if(isset($string[1])) {
            $int += (ord($string[1]) << 8);
        }

        if(isset($string[2])) {
            $int += (ord($string[2]) << 16);
        }

        if(isset($string[3])) {
            $int += (ord($string[3]) << 24);
        }

        if($int >= 4294967294) {
            $int -= 4294967296;
        }
        return $int;
		// </editor-fold>
    }

	/**
	 * Assembles a packet, ready for sending
	 * 
	 * @param char $type
	 * @return String
	 */
    private function assemblePacket($type) {
		// <editor-fold defaultstate="collapsed" desc="Assemble Packet">
        $packet = "SAMP";
        $packet .= chr(strtok($this->server, "."));
        $packet .= chr(strtok("."));
        $packet .= chr(strtok("."));
        $packet .= chr(strtok("."));
        $packet .= chr($this->port & 0xFF);
        $packet .= chr($this->port >> 8 & 0xFF);
        $packet .= $type;

        return $packet;
		// </editor-fold>
    }
    
    /**
     * Attempts to connect to the server and returns whether it was successful.
     * @return boolean
     */
    public function connect() {
		// <editor-fold defaultstate="collapsed" desc="Connect">
        $connected = false;
        fwrite($this->sock, $this->assemblePacket("p0101"));

        if(fread($this->sock, 10)) {
            if(fread($this->sock, 5) == 'p0101') {
                $connected = true;
            }
        }
        return $connected;
		// </editor-fold>
    }
    
    /**
     * Closes the connection
     */
    public function close() {
        @fclose($this->sock);
    }
}