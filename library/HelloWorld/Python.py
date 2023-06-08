from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By

# 使用Chrome浏览器驱动，确保已安装对应的浏览器驱动并配置环境变量
driver = webdriver.Chrome()

# 打开百度页面
driver.get("https://www.baidu.com/")

# 在搜索框中输入关键词并提交搜索
search_box = driver.find_element_by_name("wd")
search_box.send_keys("自动化测试")
search_box.send_keys(Keys.RETURN)

# 等待搜索结果加载完成
search_results_locator = (By.CSS_SELECTOR, "#content_left .result")
wait = WebDriverWait(driver, 10)
wait.until(EC.visibility_of_element_located(search_results_locator))

# 获取搜索结果并打印标题和链接
search_results = driver.find_elements(*search_results_locator)
for result in search_results:
    title = result.find_element_by_css_selector(".t a").text
    link = result.find_element_by_css_selector(".t a").get_attribute("href")
    print(f"标题：{title}")
    print(f"链接：{link}")
    print()

# 关闭浏览器
driver.quit()
