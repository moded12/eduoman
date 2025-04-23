<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1) اتصال
$conn = new mysqli("127.0.0.1","shneler_e","Tvvcrtv1610@_/","shneler_e");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(['error'=>$conn->connect_error]);
  exit;
}
$conn->set_charset("utf8mb4");

// 2) استلام subject_id
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;

// 3) جلب كل المجموعات للمادة دون فصل
$sql  = "SELECT id, group_name AS name
         FROM `groups`
         WHERE sub_id = ?
         ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$res  = $stmt->get_result();

// 4) بناء المصفوفة مع مفتاح semester مُحسب من الاسم
$data = [];
while ($row = $res->fetch_assoc()) {
    $name = $row['name'];
    // إذا الاسم يحوي "فصل أول" اعتبره semester=0، وإلا إذا "فصل ثاني" semester=1، وإلا افتراضيّاً 0
    if (mb_stripos($name, 'فصل أول') !== false) {
      $row['semester'] = 0;
    } elseif (mb_stripos($name, 'فصل ثان') !== false) {
      $row['semester'] = 1;
    } else {
      $row['semester'] = 0;
    }
    $data[] = $row;
}

// 5) إخراج JSON
echo json_encode(['apps_list' => $data], JSON_UNESCAPED_UNICODE);