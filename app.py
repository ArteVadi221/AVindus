
from flask import Flask, request, render_template
import os
import hashlib

app = Flask(__name__)

@app.route("/success")
def success():
    return render_template("success.html")

@app.route("/fail")
def fail():
    return render_template("fail.html")

@app.route("/sci_confirm_order", methods=["POST"])
def sci_confirm_order():
    data = request.form.to_dict()
    # Подпись PayKassa (можно проверить, если нужно)
    sign_fields = [
        data.get("merchant_id", ""),
        data.get("amount", ""),
        data.get("currency", ""),
        data.get("order_id", ""),
        data.get("secret", "")
    ]
    sign_string = ":".join(sign_fields)
    sign = hashlib.sha256(sign_string.encode()).hexdigest()
    print("[INFO] Получен запрос sci_confirm_order:")
    print(data)
    return "YES"

if __name__ == "__main__":
    app.run(debug=True)
