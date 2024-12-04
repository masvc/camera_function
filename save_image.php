<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $imageData = $data['image'];

    if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
            throw new \Exception('無効な画像形式です');
        }

        $imageData = base64_decode($imageData);

        if ($imageData === false) {
            throw new \Exception('base64デコードに失敗しました');
        }
    } else {
        throw new \Exception('base64形式の画像データではありません');
    }

    $maxFileSize = 5 * 1024 * 1024; // 5MB
    if (strlen($imageData) > $maxFileSize) {
        throw new \Exception('ファイルサイズが大きすぎます');
    }

    $fileName = 'uploads/image_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $type;
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    file_put_contents($fileName, $imageData);
    echo json_encode(['success' => true, 'fileName' => $fileName]);
} else {
    echo json_encode(['success' => false, 'message' => '無効なリクエスト']);
}
