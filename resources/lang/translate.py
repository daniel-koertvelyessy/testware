import json
import six
from google.cloud import translate_v2 as translate
from google_auth_oauthlib import flow
from google.cloud import bigquery


launch_browser = True
project = 'testwaretranslate'


appflow = flow.InstalledAppFlow.from_client_secrets_file(
    "client_secrets.json", scopes=["https://www.googleapis.com/auth/bigquery"]
)

if launch_browser:
    appflow.run_local_server()
else:
    appflow.run_console()

credentials = appflow.credentials
print(credentials)
client = bigquery.Client(project=project, credentials=credentials)
'''
Translate testWare languagefiles

Using Google Translate API
https://cloud.google.com/translate/docs/basic/translating-text#translate_translate_text-python

'''

with open('de.json', 'r') as myfile:
    data = myfile.read()

obj = json.loads(data)
langData = {}

translate_client = translate.Client()

lang = input("Sprache angeben (de,en, usw.): ")


for item in obj:
    if isinstance(item, six.binary_type):
        decodedItem = item.decode("utf-8")

    langData[item] = item
    newLang = translate_client.translate(item, target_language=lang)
    print(newLang)
    langData[item] = newLang


with open(lang + '.json', 'w') as langFile:
    json.dump(langData, langFile)
