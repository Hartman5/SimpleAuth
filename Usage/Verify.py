import json
import requests
import subprocess

path = 'https://website.com/SimpleAuth'

def verify(hwid):
    global ID, HWID, ENCRYPTED_HWID
    r = requests.get('{}/verify.php?hwid={}'.format(path, hwid))
    response = r.json()['Status']
    if response == 'True':
        ID = r.json()['ID']
        HWID = r.json()['HWID']
        ENCRYPTED_HWID = r.json()['Encrypted_HWID']
        response = True
    else:
        response = False
    return response

hwid = subprocess.check_output('wmic csproduct get uuid').decode().split('\n')[1].strip()
status = verify(hwid=hwid)
if status == False:
    print('Unverified Hwid: {}'.format(hwid))
else:
    print('Verified Hwid: {}'.format(hwid))
    #PUT YOUR CODE HERE