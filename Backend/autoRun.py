import csv
import os
import glob
import pandas as pd
import mysql.connector as msql
from datetime import datetime
from mysql.connector import Error

# ask the user about search keyword
searchCategory = input('Enter Category: ')

# if user entered something
if len(searchCategory) != 0:
    searchCategory = searchCategory.replace(" ", "")
    now = datetime.now()
    date = now.strftime("%d/%m/%Y %H:%M:%S")
    # run the command in onionSearch dir to crawl the data with given keyword
    
    os.system(f'python3 core.py "{searchCategory}" --output "\$DATE_\$SEARCH.csv" --continuous_write True --fields engine name of the link url domain')


# search for current file in dir
extension = 'csv'
found = False
result = glob.glob('*.{}'.format(extension))
for i in result:
    if i.find(searchCategory) != -1:
        found = True
        filename = i

if found:
    appendCol = date
    # now lets append column of date at end of this newly created csv
    default_text = appendCol
    newFile = filename.split('.')[0] + "_final.csv"
    # Open the input_file in read mode and output_file in write mode
    with open(filename, 'r') as read_obj, \
            open(newFile, 'w', newline='') as write_obj:
        csv_reader = csv.reader(read_obj)
        csv_writer = csv.writer(write_obj)
        # Read each row of the input csv file as list

        csv_writer.writerow(["Engine", "Name of Link", "Url", "Domain", "Date", "Category"])

        for row in csv_reader:
            row.append(default_text)
            row.append(searchCategory)
            csv_writer.writerow(row)

    # remove the original csv
    os.remove(filename)

# get data from final csv into a list
dataa = []
with open(newFile, newline='') as csvfile:
    data = csv.DictReader(csvfile)
    for row in data:
        dataa.append(row)

# append status column to this to make a new csv with _status at end
newFile_on = newFile.split('.')[0] + "_Status.csv"
with open(newFile_on, 'w', newline='') as file:
    writer = csv.writer(file)
    writer.writerow(["Engine", "Name of Link", "Url", "Domain", "Date", "Category", "Status"])
    for i in dataa:
        writer.writerow([i["Engine"], i["Name of Link"], i["Url"], i["Domain"], i["Date"], i["Category"], "Active"])

os.remove(newFile)

dataaa = []
with open("offlineLinks.csv", newline='') as csvfile:
    data = csv.DictReader(csvfile)
    for row in data:
        dataaa.append(row)

os.remove("offlineLinks.csv")

# append status column to this to make a new csv with _status at end
newFile_off =  "offlineLinks_Status.csv"
with open(newFile_off, 'w', newline='') as file:
    writerr = csv.writer(file)
    writerr.writerow(["Engine", "Name of Link", "Url", "Domain", "Date", "Category", "Status"])
    for i in dataaa:
        writerr.writerow([i["Engine"], i["Name of Link"], i["Url"], i["Domain"], default_text, searchCategory, "InActive"])

# merge both active inactive links file
csv1 = pd.read_csv(newFile_on)
csv2 = pd.read_csv(newFile_off)

print("Merging both active and inActive links csv's")

merged_data = pd.concat([csv1,csv2])
merged_data.to_csv("final.csv", sep=',', encoding='utf-8', index=False)

os.remove(newFile_off)
os.remove(newFile_on)

# now sending data to database online
link_data = pd.read_csv('final.csv', index_col = False, delimiter = ',')

try:
    conn = msql.connect(host='localhost', database='DarkWebAnalysis', user='root', password='', charset='utf8mb4',
                              collation='utf8mb4_general_ci')
    conn.set_charset_collation('utf8mb4', 'utf8mb4_general_ci')

    if conn.is_connected():
        cursor = conn.cursor()
        cursor.execute("Select database();")
        record = cursor.fetchone()
        print("Connected to database: ", record[0])
        #loop through the data frame
        for i,row in link_data.iterrows():
            #here %S means string values 
            sql = "INSERT INTO DarkWebAnalysis.link VALUES (id, %s,%s,%s,%s,%s,%s,%s)"
            cursor.execute(sql, tuple(row))
            # the connection is not auto committed by default, so we must commit to save our changes
            conn.commit()   
        print("Records inserted")
except Error as e:
            print("Error while connecting to MySQL", e)

print("Successfully Ended!!")