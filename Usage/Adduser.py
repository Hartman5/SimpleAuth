import json
import requests
import subprocess

path = 'https://website.com/SimpleAuth'

def adduser(hwid):
    global ID, HWID, ENCRYPTED_HWID, CREATED_AT
    r = requests.get('{}/adduser.php?hwid={}'.format(path, hwid))
    response = r.json()['Status']
    if response == 'True':
        ID = r.json()['ID']
        HWID = r.json()['HWID']
        ENCRYPTED_HWID = r.json()['Encrypted_HWID']
        CREATED_AT = r.json()['Created_At']
        response = True
    else:
        response = False
    return response

hwid = subprocess.check_output('wmic csproduct get uuid').decode().split('\n')[1].strip()
status = adduser(hwid=hwid)
if status == True:
    print('User Added Hwid: {}'.format(hwid))
else:
    print('Failed To Add User Hwid: {}'.format(hwid))