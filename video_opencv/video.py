from ultralytics import YOLO
import cv2
import numpy as np
from norfair import Tracker, Detection
from datetime import datetime
import openpyxl

# エクセルファイルの準備
def create_or_open_excel(file_name='count_report.xlsx'):
    try:
        wb = openpyxl.load_workbook(file_name)
    except FileNotFoundError:
        wb = openpyxl.Workbook()
        sheet = wb.active
        sheet.title = 'Count Data'
        sheet.append(['日付', '利用者人数'])  # ヘッダー追加
    return wb

# トラッカー設定
tracker = Tracker(distance_function="euclidean", distance_threshold=50)

# YOLOモデルのロード
model = YOLO('yolov8n.pt')

# 動画ファイルのパス
filepath = 'test3.MP4'
cap = cv2.VideoCapture(filepath)

# カウント用
total_count = 0
tracked_ids = set()

# エクセルファイルの準備
wb = create_or_open_excel()

# 最初の日付を設定
current_date = datetime.now().strftime('%Y-%m-%d')

while True:
    ret, frame = cap.read()
    if not ret:
        print("Error reading frame or end of video stream.")
        break

    # YOLOによる物体検出
    results = model.predict(frame, conf=0.5)

    # YOLOの結果に基づいて検出を変換
    detections = results[0].boxes.data.cpu().numpy()

    # 検出結果をトラッカー用に変換
    norfair_detections = []
    for det in detections:
        x1, y1, x2, y2, conf, cls = det
        if int(cls) == 0:  # クラス0が人物
            center_x = (x1 + x2) / 2
            center_y = (y1 + y2) / 2
            point = np.array([center_x, center_y])  # NumPy配列でポイントを渡す
            norfair_detections.append(Detection(points=point, data=(x1, y1, x2, y2)))

    # トラッキング実行
    tracked_objects = tracker.update(detections=norfair_detections)

    # フレームにトラッキング結果を描画
    for obj in tracked_objects:
        x1, y1, x2, y2 = obj.last_detection.data  # バウンディングボックス情報を取得
        cv2.rectangle(frame, (int(x1), int(y1)), (int(x2), int(y2)), (0, 255, 0), 2)
        cv2.putText(frame, f'ID: {obj.id}', (int(x1), int(y1) - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255, 0, 0), 2)

        # 新しいIDをカウント
        if obj.id not in tracked_ids:
            tracked_ids.add(obj.id)
            total_count += 1

    # カウント情報を表示
    cv2.putText(frame, f'Total Count: {total_count}', (20, 50), cv2.FONT_HERSHEY_SIMPLEX, 1, (255, 0, 0), 2)

    # フレーム表示
    cv2.imshow('Tracked Frame', frame)

    key = cv2.waitKey(1)
    if key == 27:  # ESCキーで終了
        break

    # 1日が経過するごとにカウントをエクセルに記録
    new_date = datetime.now().strftime('%Y-%m-%d')
    if new_date != current_date:  # 日付が変更された場合
        # 現在のカウントをエクセルに追加
        sheet = wb.active
        sheet.append([current_date, total_count])
        wb.save('count_report.xlsx')
        
        # カウントリセット
        total_count = 0
        tracked_ids = set()
        current_date = new_date

# 動画のキャプチャを解放
cap.release()
cv2.destroyAllWindows()

# 最後にカウントをエクセルに記録
sheet = wb.active
sheet.append([current_date, total_count])
wb.save('count_report.xlsx')
