#解説1
import cv2
import numpy as np
from matplotlib import pyplot as plt

#解説2
# 画像をロードし、色空間をRGBに変換します
img = cv2.imread('test.jpg')
# OpenCVのデフォルトの色空間BGRからRGBに変換
img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)  

#解説3
hog = cv2.HOGDescriptor()
hog.setSVMDetector(cv2.HOGDescriptor_getDefaultPeopleDetector())
boxes, weights = hog.detectMultiScale(img, winStride=(4, 4), padding=(8, 8), scale=1.04)

#解説4
# 検出された人物を囲む矩形を描画し、画像を表示します
for (x, y, w, h) in boxes:
    cv2.rectangle(img, (x, y), (x + w, y + h), (0, 0, 255), 2)
plt.imshow(img)
plt.show()