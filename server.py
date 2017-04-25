import os
import psycopg2
import psycopg2.extras
import uuid
import binascii
from flask import Flask, render_template, request, redirect, session
from flask_socketio import SocketIO, emit, send

app = Flask(__name__)
app.secret_key = binascii.hexlify(os.urandom(24))
socketio = SocketIO(app)


@app.route('/')
def mainIndex():
	return render_template('index.html')


# start the server
if __name__ == '__main__':
	app.run(host=os.getenv('IP', '0.0.0.0'), port =int(os.getenv('PORT', 8080)), debug=True)
	
# if __name__ == '__main__':
# 	socketio.run(app, host='0.0.0.0', port=8080, debug=True)