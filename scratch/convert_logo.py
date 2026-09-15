import sys
try:
    from PIL import Image
    import os
    img_path = 'C:/Users/kylej_z264ll1/RubiknowsV2/RK4.png'
    out_path = 'C:/Users/kylej_z264ll1/RubiknowsV2/public/RK4.webp'
    img = Image.open(img_path)
    img.thumbnail((800, 800))
    img.save(out_path, 'WEBP', quality=85)
    print("Success")
except Exception as e:
    print("Error:", e)
