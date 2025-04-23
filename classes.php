<?php
header('Content-Type: application/json; charset=utf-8');

// 1) إعداد الاتصال
$conn = new mysqli("127.0.0.1", "shneler_e", "Tvvcrtv1610@_/", "shneler_e");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(['error' => 'Connection failed']);
  exit;
}
// 2) تأكد من ترميز UTF-8
$conn->set_charset("utf8mb4");

// 3) جلب الصفوف الدراسية (IDs حسب ترتيبك من 1 إلى 12)
$ids = [1,2,3,59,60,61,62,63,64,65,80,81];
$in  = implode(',', $ids);

// 4) استعلام الصفوف
$sql = "
  SELECT id, name
  FROM classes
  WHERE id IN ($in)
  ORDER BY FIELD(id, $in)
";
$res = $conn->query($sql);
if (!$res) {
  http_response_code(500);
  echo json_encode(['error' => $conn->error]);
  exit;
}

// 5) بناء المصفوفة
$data = [];
while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}

// 6) إخراج JSON
echo json_encode(['apps_list' => $data], JSON_UNESCAPED_UNICODE);