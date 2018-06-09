from pywinauto.application import Application
import sys
import timeit
import time
from datetime import timedelta

elapsed = 938274
# timeFileWrite = open("timeSpent.txt", "w")
timeFileRead = open("timeSpent.txt", "r")

print(timeFileRead.read())
timeFileRead.close()

timeFileWrite = open("timeSpent.txt", "w")
timeFileWrite.write(str(timedelta(seconds=elapsed)))
timeFileWrite.close()

elapsed += 912743

timeFileWrite = open("timeSpent.txt", "w")
timeFileWrite.write(str(timedelta(seconds=elapsed)))
timeFileWrite.close()

timeFileRead = open("timeSpent.txt", "r")

print(timeFileRead.read())
timeFileRead.close()



