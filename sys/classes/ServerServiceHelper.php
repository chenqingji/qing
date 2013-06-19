<?php

/**
 * 获取服务器信息工具类
 */
class ServerServiceHelper {

    /**
     * mysql服务是否正常
     * 
     * @param $host string 主机
     * @param $user string 用户
     * @param $pass string 密码
     * @param $port int 端口号
     * @return boolean
     */
    public static function isMysqlServiceOk($host, $user, $pass, $port = 3306) {
        $conn = @mysql_connect($host . ":" . ((string) $port), $user, $pass);
        if ($conn) {
            $ping = @mysql_ping($conn);
            if ($ping) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * memcached服务是否正常
     * 
     * @param $host string 主机
     * @param $port string 端口号
     * @return boolean
     */
    public static function isMemcachedServiceOk($host, $port = 11211) {
        return self::isSocketConnectOk($host, $port);
    }

    /**
     * web服务是否正常
     * 
     * @param $host string 主机
     * @param $port string 端口号
     * @return boolean
     */
    public static function isWebServiceOk($host, $port = 80) {
        return self::isSocketConnectOk($host, $port);
    }

    /**
     * socket连接是否正常
     * 
     * @param $host string 主机
     * @param $port string 端口号
     * @return boolean
     */
    public static function isSocketConnectOk($host, $port) {
        $is_connect_ok = false;
        $socket = new Socket($host, $port);
        if ($socket->connect()) {
            $is_connect_ok = true;
            $socket->close();
        }
        return $is_connect_ok;
    }
    
    /**
     * 系统负载 0.29, 0.32, 0.32
     * 
     * @return string
     */
    public static function getLoadInfo() {
        return OSUtils::getSystemLoadInfo();
    }    
    
    /**
     * 内存使用情况 物理内存和swap
     * 
     * @return array
     */
    public static function getMemoryInfo() {
        $output = '';
        $memoryArr = array();
        $swapArr = array();
        exec("free", $output);
        // memory
        $memoryResult = split(" ", $output [1]);
        for ($i = 0; $i < count($memoryResult); $i++) {
            if ($memoryResult [$i] != '') {
                $memoryArr [] = $memoryResult [$i];
            }
        }
        if ($memoryArr [1] != 0) {
            $memoryPercent = $memoryArr [2] / $memoryArr [1] * 100;
        } else {
            $memoryPercent = 0;
        }
        $memoryUsed = StringUtils::transUnit($memoryArr [2] * 1024);
        $memoryTotal = StringUtils::transUnit($memoryArr [1] * 1024);

        // swap
        $swapResult = split(" ", $output [3]);
        for ($i = 0; $i < count($swapResult); $i++) {
            if ($swapResult [$i] != '') {
                $swapArr [] = $swapResult [$i];
            }
        }
        if ($swapArr [1] != 0) {
            $swapPercent = $swapArr [2] / $swapArr [1] * 100;
        } else {
            $swapPercent = 0;
        }
        $swapUsed = StringUtils::transUnit($swapArr [2] * 1024);
        $swapTotal = StringUtils::transUnit($swapArr [1] * 1024);

        return array(
            'physical' => array('used' => $memoryUsed, 'total' => $memoryTotal, 'percent' => $memoryPercent),
            'swap' => array('used' => $swapUsed, 'total' => $swapTotal, 'percent' => $swapPercent));
    }    
    
    /**
     * 获取硬盘使用情况
     * 
     * @return array
     */
    public static function getDiskInfo() {
        $diskInfoArr = array();
        exec('df -h -P', $output);
        $ouput = array_shift($output);
        foreach ($output as $line) {
            $tempArr = array();
            preg_match_all("/[^ ]+/", $line, $matches);
            $match = $matches [0];
            $length = count($match);

            $tempArr ['type'] = $match [$length - 1];
            $tempArr ['percent'] = $match [$length - 2];
            $tempArr ['used'] = $match [$length - 4];
            $tempArr ['total'] = $match [$length - 5];
            if (!$tempArr ['total']) {
                continue;
            }
            $diskInfoArr [] = $tempArr;
            unset($tempArr);
        }
        return $diskInfoArr;
    }

    /**
     * 网络流量 tx:out rx:in
     * 
     * @return array
     */
    public static function getNetworkInfo() {
        exec("ifconfig", $output);
        $output = split(":", $output [7]);
        $rx1 = split(" ", $output [1]);
        $tx1 = split(" ", $output [2]);
        sleep(1);
        exec("ifconfig", $output);
        $output = split(":", $output [10]);
        $rx2 = split(" ", $output [1]);
        $tx2 = split(" ", $output [2]);

        if ($rx2 [0] - $rx1 [0] >= 0) {
            $rx = $rx2 [0] - $rx1 [0];
        } else {
            $rx = $rx2 [0];
        }
        if ($tx2 [0] - $tx1 [0] >= 0) {
            $tx = $tx2 [0] - $tx1 [0];
        } else {
            $tx = $tx2 [0];
        }
        return array('rx' => $rx, 'tx' => $tx);
    }
    
   /**
     * unix登录人数
     * 
     * @return int
     */
    public static function getLoginInfo() {
        exec("who", $output);
        return count($output);
    }

    /**
     * cpu信息
     * 
     * @return string
     */
    public static function getCpuInfo() {
        $content = file("/proc/cpuinfo");
        $cpuArr = split(":", $content [4]);
        return $cpuArr [1];
    }

    /**
     * 获取服务器硬盘信息 使用百分比 总硬盘量 已使用硬盘量
     * 
     * @return array
     */
    public static function getServerDiskInfo() {
        $total = $used = $percent = 0;
        $output = array();

        exec('df -k -P', $output);
        for ($i = 1; $i < count($output); $i++) {
            $line = $output [$i];
            preg_match_all("/[^ ]+/", $line, $matches);
            $match = $matches [0];
            $length = count($match);
            if (substr($match [0], 0, 5) != '/dev/')
                continue;
            $used += $match [$length - 4];
            $total += $match [$length - 5];
        }
        $percent = round($used / $total * 100, 2) . '%';
        $total = StringUtils::transUnit($total * 1024);
        $used = StringUtils::transUnit($used * 1024);
        return array('percent' => $percent, 'total' => $total, 'used' => $used);
    }        


}
