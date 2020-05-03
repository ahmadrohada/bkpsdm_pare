<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPBulananJFT;
use App\Models\HistoryJabatan;


use App\Helpers\Pustaka;

trait Pengecualian
{




    protected function pengecualian(){
      
        //Pengecualian untuk irban dan KPUD
        $a = ['143','144','145','146','1326','1327','1328','1329'];
        //pengecualian untuk KEC Telukjambe Barat
        $b = ['1235','1236','1237','1238','1239'];
        //KEC Cikampek
        $c = ['1089','1090','1091','1092','1093'];
        //KEC JAtisari
        $d = ['1098','1099','1100','1101','1102'];
        //KEC Ciampel
        $e = ['1335','1336','1337','1338','1339'];
        //KEC teluk jambe timur
        $f = ['1008','1009','1010','1011','1012'];
        //KEC Klari
        $g = ['1017','1018','1019','1020','1021'];
        //KEC karawang barat
        $h = ['1271','1272','1273','1274','1275'];
        //KEC Tegal waru
        $i = ['1244','1245','1246','1247','1248'];
        //KEC pangkalan
        $j = ['999','1000','1001','1002','1003'];
        //KEC Kutawaluya
        $k = ['1035','1036','1037','1038','1039'];
        //KEC lemahabang
        $l = ['1143','1144','1145','1146','1147'];
        //KEC purwasari
        $m = ['1253','1254','1255','1256','1257'];
        //KEC KAwarang Timur
        $n = ['1206','1207','1208','1209','1210'];
        //KEC Kota BAru
        $o = ['1197','1198','1199','1200','1201'];
        //KEC Banyusari
        $p = ['1188','1189','1190','1191','1192'];
        //KEC Tirtamulya
        $q = ['1116','1117','1118','1119','1120'];
        //KEC Jayakerta
        $r = ['1170','1171','1172','1173','1174'];
        //KEC PAkisjaya
        $s = ['1080','1081','1082','1083','1084'];
        //KEC Cibuaya
        $t = ['1071','1072','1073','1074','1075'];
        //KEC Majalaya
        $u = ['1161','1162','1163','1164','1165'];
        //KEC Batujaya
        $v = ['1044','1045','1046','1047','1048'];
        //KEC Rwamerta
        $w = ['1134','1135','1136','1137','1138'];
        //KEC Cilebar
        $x = ['1262','1263','1264','1265','1266'];
        //KEC tirtajaya
        $y = ['1053','1054','1055','1056','1057'];
        //KEC Rengas dengklok
        $z = ['1026','1027','1028','1029','1030'];
        //KEC RCilamaya kulon
        $aa = ['1179','1180','1181','1182','1183'];
        //KEC RCilamaya Wetan
        $aa = ['1107','1108','1109','1110','1111'];
        //KEC Tempuran
        $ab = ['1152','1153','1154','1155','1156'];
        //KEC telagasari
        $ac = ['1125','1126','1127','1128','1129'];
        //KEC PEDES
        $ad = ['1062','1063','1064','1065','1066'];
        //KEC CILAMAYA KULON
        $ae = ['1179','1180','1181','1182','1183'];

        $kearsipan = ['786','787'];




        $pengecualian = array_merge($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s,$t,$u,$v,$w,$x,$y,$z,$aa,$ab,$ac,$ad,$ae,$kearsipan);

        return $pengecualian;
        
    }





}