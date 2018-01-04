#!/usr/bin/env python
# coding=utf-8

from selenium import webdriver

url = "http://localhost:8888"
driver = webdriver.PhantomJS()
driver.get(url)

data = driver.title

print data
