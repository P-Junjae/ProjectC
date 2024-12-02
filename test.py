from ultralytics import YOLO
import pandas as pd

# モデルをロード
model = YOLO("yolov8n.pt")

# 推論を実行
results = model("test.mp4")  # 画像ファイルを指定
print(results)  # 予測結果を確認

# 結果を保存するリスト
data = []

# 「person」クラス（人物）のインデックス
person_class_index = 0  # YOLOv8では「person」は通常0番目のクラスです

# 人数カウント用変数
person_count = 0

# 推論結果をループして必要な情報を抽出
for result in results:
    for box in result.boxes:
        # クラス名と信頼度を取得
        class_name = box.cls
        confidence = box.conf
        
        # 「person」クラスの場合、人数をカウント
        if class_name == person_class_index:
            person_count += 1
        
        # 結果をリストに追加
        data.append([class_name, confidence])

# pandas DataFrame に変換
df = pd.DataFrame(data, columns=["Class", "Confidence"])

# 既存のExcelファイルに追記（もしあれば）
excel_path = 'count_report.xlsx'

try:
    # 既存のExcelファイルを読み込む
    existing_df = pd.read_excel(excel_path)

    # 既存のDataFrameに新しいデータを追加
    df = pd.concat([existing_df, df], ignore_index=True)

except FileNotFoundError:
    # ファイルがなければ、新しく作成
    pass

# 人数カウントの結果を追加
person_count_df = pd.DataFrame([{"Class": "Person Count", "Confidence": person_count}])

# 結果を結合（person_countを追加）
df = pd.concat([df, person_count_df], ignore_index=True)

# 結果をExcelに書き込む
df.to_excel(excel_path, index=False)

print(f"結果は {excel_path} に書き込まれました。")
