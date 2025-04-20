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
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>المعلم الإلكتروني - سلطنة عُمان</title>
    <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8177765238464378' crossorigin='anonymous'></script>
    <style>
        :root {
            --bg-color: #f8f9fa;
            --text-color: #333;
            --link-color: #007bff; /* Primary blue */
            --hover-link-color: #0056b3;
            --item-bg: #fff;
            --item-border: #ddd;
            --sub-item-bg: #f8f9fa; /* Light gray */
            --box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            --transition-duration: 0.3s;
        }

        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-color);
            line-height: 1.6;
            text-align: center;
            background-color: var(--bg-color);
            transition: background-color var(--transition-duration), color var(--transition-duration);
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: var(--item-bg);
            border-radius: 10px;
            box-shadow: var(--box-shadow);
        }

        h1 {
            font-size: 2.5rem;
            color: var(--link-color);
            margin-bottom: 25px;
        }

        .item {
            background-color: var(--item-bg);
            border: 1px solid var(--item-border);
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: var(--box-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .item a {
            display: block;
            text-decoration: none;
            color: var(--text-color);
            font-weight: bold;
            transition: color var(--transition-duration);
        }

        .item a:hover {
            color: var(--link-color);
        }

        .sub-items {
            margin-top: 10px;
            display: none; /* Initially hidden */
        }

        .sub-items .frame {
            display: flex;
            justify-content: space-around; /* Evenly space the semester links */
            gap: 15px;
            background-color: var(--sub-item-bg);
            padding: 12px;
            border-radius: 8px;
            box-shadow: inset var(--box-shadow);
        }

        .sub-items a {
            display: inline-block;
            color: var(--link-color);
            font-weight: bold;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #e9ecef; /* Light background for semester buttons */
            transition: background-color var(--transition-duration), color var(--transition-duration);
        }

        .sub-items a:hover {
            background-color: var(--hover-link-color);
            color: #fff;
        }

        .back {
            display: inline-block;
            margin-top: 25px;
            color: var(--text-color);
            text-decoration: none;
            font-weight: bold;
            padding: 12px 20px;
            background-color: #6c757d; /* Secondary gray */
            border-radius: 8px;
            transition: background-color var(--transition-duration), color var(--transition-duration);
        }

        .back:hover {
            background-color: var(--link-color);
            color: #fff;
        }

        .material-link {
            display: inline-block;
            margin-top: 15px;
            color: var(--link-color);
            font-weight: bold;
            text-decoration: none;
            padding: 10px 18px;
            background-color: #d1ecf1; /* Light blue background */
            border-radius: 5px;
            border: 1px solid #bee5eb;
            transition: background-color var(--transition-duration), color var(--transition-duration), border-color var(--transition-duration);
        }

        .material-link:hover {
            background-color: var(--hover-link-color);
            color: #fff;
            border-color: var(--hover-link-color);
        }

        .no-content {
            color: #dc3545; /* Danger red */
            margin-top: 15px;
            font-weight: bold;
        }
    
/* 🌙 Dark Mode Support */
body.dark-mode {
    --bg-color: #1c1c1c;
    --text-color: #f0f0f0;
    --link-color: #4ea8ff;
    --hover-link-color: #82cfff;
    --item-bg: #2b2b2b;
    --item-border: #444;
    --sub-item-bg: #1f1f1f;
}

</style>

    <script>
        function toggleSemesters(id) {
            // Close all other .sub-items
            document.querySelectorAll('.sub-items').forEach(function(item) {
                if (item.id !== id) {
                    item.style.display = 'none';
                }
            });

            // Toggle the visibility of the clicked .sub-items
            var element = document.getElementById(id);
            if (element) {
                element.style.display = element.style.display === 'block' ? 'none' : 'block';
            }
        }
    </script>
</head>
<body>
<div class='container'>

<div style='text-align:left; margin-bottom: 10px;'>
  <button onclick='toggleTheme()' style='padding: 8px 16px; border-radius: 8px; cursor: pointer;'>🌓 الوضع الليلي</button>
</div>

    <h1>المعلم الإلكتروني - سلطنة عُمان</h1>
    
<!-- Google AdSense -->
<div style='margin: 20px 0;'>
    <ins class='adsbygoogle'
         style='display:block; text-align:center;'
         data-ad-client='ca-pub-8177765238464378'
         data-ad-slot='1234567890'
         data-ad-format='auto'
         data-full-width-responsive='true'></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
";

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
            echo "<a class='material-link' href='$real_link' target='_blank'>فتح الملف في صفحة جديدة 🔗</a>";
        } else {
            echo "<p class='no-content'>تعذر العثور على رابط المحتوى.</p>";
        }
        echo "</div>";
    } else {
        echo "<p class='no-content'>الموضوع غير موجود.</p>";
    }

    echo "<a class='back' href='?group_id=$group_id&subject_id=$subject_id&class_id=$class_id&semester=$semester'>⬅️ رجوع</a>";
} elseif (isset($_GET['group_id']) && isset($_GET['semester']) && !isset($_GET['view_material'])) {
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
        echo "<p class='no-content'>لا يوجد مجموعات تعليمية</p>";
    }

    echo "<a class='back' href='?subject_id=$subject_id&class_id=$class_id'>⬅️ رجوع</a>";
} elseif (isset($_GET['show_materials'])) {
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
        echo "<p class='no-content'>لا يوجد مواضيع تعليمية داخل هذه المجموعة.</p>";
    }

    echo "<a class='back' href='?group_id=$subject_id&semester=$semester&subject_id=$subject_id&class_id=$class_id'>⬅️ رجوع</a>";
} elseif (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $data = fetchData("{$base}subject.php?id=$class_id");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;

    if (!empty($items)) {
        foreach ($items as $subject) {
            echo "<div class='item' onclick='toggleSemesters(\"semesters-{$subject['id']}\")'>
                        {$subject['name']}
                        <div id='semesters-{$subject['id']}' class='sub-items'>
                            <div class='frame'>
                                <a href='?group_id={$subject['id']}&semester=0'>الفصل الأول</a>
                                <a href='?group_id={$subject['id']}&semester=1'>الفصل الثاني</a>
                            </div>
                        </div>
                    </div>";
        }
    } else {
        echo "<p class='no-content'>لا يوجد مواد دراسية</p>";
    }
    echo "<a class='back' href='?'>⬅️ رجوع</a>";
} else {
    $data = fetchData("{$base}classes.php?id=1");
    $items = isset($data['apps_list']) ? $data['apps_list'] : $data;

    if (!empty($items)) {
        foreach ($items as $class) {
            echo "<div class='item'><a href='?class_id={$class['id']}'>{$class['name']}</a></div>";
        }
    } else {
        echo "<p class='no-content'>لا يوجد صفوف دراسية</p>";
    }
}

echo "</div>
<script>
function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
}
window.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
    }
});
</script>

</body></html>";
?>
