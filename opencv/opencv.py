import cv2

# HOGDescriptorを設定し、人物検出用のデフォルトSVMをセット
hog = cv2.HOGDescriptor()
hog.setSVMDetector(cv2.HOGDescriptor_getDefaultPeopleDetector())

# カメラを起動 (デバイスIDは0が通常デフォルトカメラ)
cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print("カメラを開くことができませんでした。")
    exit()

print("リアルタイム人物検出を開始します。終了するには 'q' を押してください。")

while True:
    # カメラからフレームを取得
    ret, frame = cap.read()
    if not ret:
        print("フレームを取得できませんでした。")
        break

    # フレームをグレースケールからRGBに変換
    frame_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

    # HOGで人物検出
    boxes, weights = hog.detectMultiScale(frame_rgb, winStride=(8, 8), padding=(8, 8), scale=1.05)

    # 検出結果を描画
    for (x, y, w, h) in boxes:
        cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)  # 緑色の枠で描画

    # フレームをウィンドウに表示
    cv2.imshow('リアルタイム人物検出', frame)

    # 'q'を押したら終了
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# カメラとウィンドウを解放
cap.release()
cv2.destroyAllWindows()
