<?php
    $val = $_POST['val'];
    $time = [
        "start" => $val['ss'],
        "end" => $val['se'],
    ];
    $sql = "INSERT INTO reserved (knd_class, user, teacher, date_class, time_class, degre, category, field, explain_user, address, link, price, commission, status, `date`, `time`)
    VALUES (:knd_class, :user, :teacher, :date_class, :time_class, :degre, :category, :field, :explain_user, :address, :link, :price, :commission, :status, :date, :time)";

    $db->query($sql);
    $db->bind(":knd_class", $val['k']);
    $db->bind(":user", $val['u']);
    $db->bind(":teacher", $val['t']);
    $db->bind(":date_class", $val['date']);
    $db->bind(":degre", $val['d']);
    $db->bind(":category", $val['c']);
    $db->bind(":field", $val['f']);
    $db->bind(":explain_user", $val['e']);
    $db->bind(":address", $val['ad']);
    $db->bind(":link", $val['l']);
    $db->bind(":price", $val['p']);
    $db->bind(":commission", $val['cm']);
    $db->bind(":time", date("H:i"));
    $db->bind(":date", jdate("Y/n/d"));
    $db->bind(":status", ($val['ap'] == '0') ? '2' : '5' );
    $db->bind(":time_class", json_encode($time, JSON_UNESCAPED_UNICODE));

    $changed = $db->execute();
    $arr = "";
    $cod = 200;
    $txt = 'OK';
?>
