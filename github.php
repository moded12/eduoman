<?php
function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

function fetchMaterialAttachment($material_id) {
    $host = "127.0.0.1";
    $user = "shneler_e";
    $password = "Tvvcrtv1610@_/";
    $dbname = "shneler_e";

    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        return false;
    }

    $stmt = $conn->prepare("SELECT link, photo FROM images WHERE mat_id = ? LIMIT 1");
    $stmt->bind_param("i", $material_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if (!$row) return false;

    if (!empty($row['link'])) {
        return $row['link'];
    } elseif (!empty($row['photo'])) {
        return "https://shneler.com" . $row['photo'];
    } else {
        return false;
    }
}

echo "<!DOCTYPE html>
<html lang='ar' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <title>المعلم الإلكتروني - سلطنة عُمان</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            color: #007BFF;
            text-align: center;
            margin-bottom: 20px;
        }

        .item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .item:hover {
            transform: translateY(-4px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        .sub-items {
            margin-top: 10px;
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 10px 15px;
            display: none;
        }

        .sub-items a {
            display: block;
            color: #0056b3;
            margin: 8px 0;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .sub-items a:hover {
            color: #003d80;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            background-color: #e9ecef;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .back:hover {
            background-color: #007BFF;
            color: #fff;
        }
    </style>
</head>
<body>
<div class='container'>
    <h1>المعلم الإلكتروني - سلطنة عُمان</h1>";

$base = "https://www.shneler.com/oman/api/";

if (isset($_GET['view_material'])) {
    $material_id = $_GET['view_material'];
    $group_id = $_GET['group_id'];
    $subject_id = $_GET['subject_id'];
    $class_id = $_GET['class_id'];
    $semester = $_GET['semester'];
    $data = fetchData("{$base}materials.php?id=$group_id");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;

    $material = null;
    foreach ($items as $item) {
        if ($item['id'] == $material_id) {
            $material = $item;
            break;
        }
    }

    if ($material) {
        $name = $material['name'] ?? 'بدون اسم';
        $real_link = fetchMaterialAttachment($material_id);
        echo "<div class='item'><h3>$name</h3>";
        if ($real_link) {
            echo "<a href='$real_link' target='_blank'>فتح الملف في صفحة جديدة 🔗</a>";
        } else {
            echo "<p>تعذر العثور على رابط المحتوى.</p>";
        }
        echo "</div>";
    } else {
        echo "<p>الموضوع غير موجود.</p>";
    }

    echo "<a class='back' href='?group_id=$group_id&subject_id=$subject_id&class_id=$class_id&semester=$semester'>⬅️ رجوع</a>";
}
elseif (isset($_GET['group_id']) && isset($_GET['semester']) && !isset($_GET['view_material'])) {
    $subject_id = $_GET['subject_id'];
    $class_id = $_GET['class_id'];
    $semester = $_GET['semester'];
    $subject_id = $_GET['group_id'];

    $data = fetchData("{$base}groups.php?id=$subject_id&semester=$semester");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;

    if (!empty($items)) {
        foreach ($items as $group) {
            $groupName = $group['name'] ?? $group['group_name'] ?? 'مجموعة';
            $groupId = $group['id'];
            echo "<div class='item'><a href='?show_materials=$groupId&subject_id=$subject_id&class_id=$class_id&semester=$semester'>$groupName</a></div>";
        }
    } else {
        echo "<p>لا يوجد مجموعات تعليمية</p>";
    }

    echo "<a class='back' href='?subject_id=$subject_id&class_id=$class_id'>⬅️ رجوع</a>";
}
elseif (isset($_GET['show_materials'])) {
    $group_id = $_GET['show_materials'];
    $subject_id = $_GET['subject_id'];
    $class_id = $_GET['class_id'];
    $semester = $_GET['semester'];

    $data = fetchData("{$base}materials.php?id=$group_id");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;

    if (!empty($items)) {
        foreach ($items as $item) {
            $name = $item['name'] ?? 'بدون عنوان';
            $mid = $item['id'];
            echo "<div class='item'><a href='?view_material=$mid&group_id=$group_id&subject_id=$subject_id&class_id=$class_id&semester=$semester'>$name</a></div>";
        }
    } else {
        echo "<p>لا يوجد مواضيع تعليمية داخل هذه المجموعة.</p>";
    }

    echo "<a class='back' href='?group_id=$subject_id&semester=$semester&subject_id=$subject_id&class_id=$class_id'>⬅️ رجوع</a>";
}
elseif (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $data = fetchData("{$base}subject.php?id=$class_id");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;
    if (!empty($items)) {
        foreach ($items as $subject) {
            echo "<div class='item' onclick='toggleSemesters(\"semesters-{$subject['id']}\")'>
                    {$subject['name']}
                    <div id='semesters-{$subject['id']}' class='sub-items'>
                        <a href='?group_id={$subject['id']}&semester=0'>الفصل الأول</a>
                        <a href='?group_id={$subject['id']}&semester=1'>الفصل الثاني</a>
                    </div>
                  </div>";
        }
    } else {
        echo "<p>لا يوجد مواد دراسية</p>";
    }
    echo "<a class='back' href='?'>⬅️ رجوع</a>";
}
else {
    $data = fetchData("{$base}classes.php?id=1");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;
    if (!empty($items)) {
        foreach ($items as $class) {
            echo "<div class='item'><a href='?class_id={$class['id']}'>{$class['name']}</a></div>";
        }
    } else {
        echo "<p>لا يوجد صفوف دراسية</p>";
    }
}
echo "<script>
    function toggleSemesters(id) {
        document.querySelectorAll('.sub-items').forEach(function(item) {
            item.style.display = 'none';
        });

        var element = document.getElementById(id);
        if (element) {
            element.style.display = element.style.display === 'block' ? 'none' : 'block';
        }
    }
</script>";
echo "</div></body></html>";
?>