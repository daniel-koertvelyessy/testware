import json
import sys
from google_trans_new import google_translator


class ProgressBar():
    def __init__(self, total, suffix, count=0, bar_len=60, bar_symbol='='):
        self.total = total
        self.count = count
        self.suffix = suffix
        self.bar_len = bar_len
        self.bar_symbol = bar_symbol

    def draw(self):
        self.count += 1
        filled_len = int(round(self.bar_len * self.count / float(self.total)))
        percents = round(100.0 * self.count / float(self.total), 1)
        bar = self.bar_symbol * filled_len + '-' * (self.bar_len - filled_len)
        sys.stdout.write('[%s] %s%s %s\r' %
                         (bar, percents, '%', self.suffix))
        sys.stdout.flush()


translator = google_translator()
lang = input('Sprache angeben (de, en fr ...): ')
langData = {}
skipped = 0
entrie = 0

with open('de.json', 'r', encoding='utf-8') as myfile:
    data = myfile.read()

json_entries = data.count('": ')
pg = ProgressBar(
    json_entries, f' von {json_entries} Einträgen übersetzt', bar_symbol='⫼')
obj = json.loads(data)

for item in obj:
    entrie += 1
    text = obj[item]
    translated = translator.translate(text, lang_tgt=lang)
    if type(translated) is not list:
        if text == translated.rstrip():
            skipped += 1
        langData[item] = translated[0].upper() + translated[1:].rstrip()  #
    else:
        if text == translated[0].rstrip():
            skipped += 1
            langData[item] = translated[0][0].upper() + \
                translated[0][1:].rstrip()  #

    pg.draw()

with open(lang + '.json', 'w', encoding='utf-8') as langFile:
    json.dump(langData, langFile, ensure_ascii=False)
    print(
        f'\n\nDatei erstellt ✔\n{skipped} Einträge wurde nicht übersetzt :( ')
