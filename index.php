<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カメラ撮影</title>
    <link rel="stylesheet" href="css/camera.css">
</head>

<body>
    <div class="camera-container">
        <h1>写真を撮影</h1>
        <video id="camera" autoplay playsinline></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <div class="camera-controls">
            <button id="captureBtn">撮影</button>
            <button id="retakeBtn" style="display: none;">撮り直し</button>
        </div>
        <img id="preview" style="display: none;">
        <div class="navigation-buttons">
            <a href="main.php" class="nav-button">写真一覧を見る</a>
        </div>
    </div>
    <script>
        class CameraManager {
            constructor() {
                this.video = document.getElementById('camera');
                this.canvas = document.getElementById('canvas');
                this.preview = document.getElementById('preview');
                this.captureBtn = document.getElementById('captureBtn');
                this.retakeBtn = document.getElementById('retakeBtn');
                this.stream = null;

                this.initializeCamera();
                this.setupEventListeners();
            }

            async initializeCamera() {
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            },
                            facingMode: 'user'
                        }
                    });
                    this.video.srcObject = this.stream;
                } catch (error) {
                    console.error('カメラの初期化エラー:', error);
                }
            }

            setupEventListeners() {
                this.captureBtn.addEventListener('click', () => this.captureImage());
                this.retakeBtn.addEventListener('click', () => this.retakePhoto());
            }

            captureImage() {
                this.canvas.width = this.video.videoWidth;
                this.canvas.height = this.video.videoHeight;
                const context = this.canvas.getContext('2d');
                context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);
                const imageData = this.canvas.toDataURL('image/jpeg');
                this.preview.src = imageData;
                this.preview.style.display = 'block';
                this.video.style.display = 'none';
                this.captureBtn.style.display = 'none';
                this.retakeBtn.style.display = 'block';

                this.saveImage(imageData);
            }

            async saveImage(imageData) {
                try {
                    const response = await fetch('save_image.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            image: imageData
                        })
                    });

                    if (response.ok) {
                        console.log('画像が保存されました');
                    } else {
                        console.error('画像の保存に失敗しました');
                    }
                } catch (error) {
                    console.error('画像保存エラー:', error);
                }
            }

            retakePhoto() {
                this.preview.style.display = 'none';
                this.video.style.display = 'block';
                this.captureBtn.style.display = 'block';
                this.retakeBtn.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new CameraManager();
        });
    </script>
</body>

</html>