<?php
header('Content-Type: application/json; charset=utf-8');

// 1) اتصال بقاعدة البيانات
$conn = new mysqli("127.0.0.1", "shneler_e", "Tvvcrtv1610@_/", "shneler_e");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(['error'=>'Connection failed']);
  exit;
}
$conn->set_charset("utf8mb4");

// 2) استقبل معرّف الصف عبر GET
$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

// 3) جلب المواد المرتبطة بهذا الصف
$sql = "
  SELECT id, name
  FROM subjects
  WHERE class_id = $class_id
  ORDER BY id ASC
";
$res = $conn->query($sql);
if (!$res) {
  http_response_code(500);
  echo json_encode(['error'=>$conn->error]);
  exit;
}

// 4) بناء المصفوفة
$data = [];
while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}

// 5) إخراج JSON
echo json_encode(['apps_list'=>$data], JSON_UNESCAPED_UNICODE);