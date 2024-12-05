from ultralytics import YOLO
import cv2
import numpy as np
from norfair import Tracker, Detection
from datetime import datetime
import openpyxl
from tkinter import Tk, filedialog

# エクセルファイルの準備
def create_or_open_excel(file_path):
    try:
        wb = openpyxl.load_workbook(file_path)
        sheet = wb.active
    except FileNotFoundError:
        wb = openpyxl.Workbook()
        sheet = wb.active
        sheet.title = 'Count Data'
        sheet.append(['日付', '利用者人数'])  # ヘッダー追加
    return wb, sheet

# トラッカー設定
tracker = Tracker(distance_function="euclidean", distance_threshold=50)

# YOLOモデルのロード
model = YOLO('yolov8n.pt')

# Tkinterを使用してファイル選択ダイアログを開く
def select_video_file():
    root = Tk()
    root.withdraw()  # Tkinterウィンドウを非表示にする
    video_path = filedialog.askopenfilename(
        title="動画ファイルを選択してください",
        filetypes=[("動画ファイル", "*.mp4;*.avi;*.mov"), ("すべてのファイル", "*.*")]
    )
    return video_path

# Tkinterを使用して保存先を選択
def select_save_path():
    root = Tk()
    root.withdraw()  # Tkinterウィンドウを非表示にする
    save_path = filedialog.asksaveasfilename(
        title="保存先を選択してください",
        defaultextension=".xlsx",
        filetypes=[("Excelファイル", "*.xlsx"), ("すべてのファイル", "*.*")]
    )
    return save_path

# 動画ファイルのパスを選択
video_path = select_video_file()
if not video_path:
    print("動画ファイルが選択されませんでした。")
    exit()

# 保存先を選択
excel_path = select_save_path()
if not excel_path:
    print("保存先が選択されませんでした。")
    exit()

cap = cv2.VideoCapture(video_path)

if not cap.isOpened():
    print("Error: Could not open video.")
    exit()
else:
    print("Video opened successfully.")

# カウント用
total_count = 0
tracked_ids = set()

# エクセルファイルの準備
wb, sheet = create_or_open_excel(excel_path)

# 最初の日付を設定
current_date = datetime.now().strftime('%Y-%m-%d')

while True:
    ret, frame = cap.read()
    if not ret:
        print(f"Error reading frame at {cap.get(cv2.CAP_PROP_POS_FRAMES)}")
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
        sheet.append([current_date, total_count])
        wb.save(excel_path)  # 保存

        # カウントリセット
        total_count = 0
        tracked_ids = set()
        current_date = new_date

# 動画のキャプチャを解放
cap.release()
cv2.destroyAllWindows()

# 最後にカウントをエクセルに記録
sheet.append([current_date, total_count])
wb.save(excel_path)  # 保存
