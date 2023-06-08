#!/bin/bash

# 定义输入文件和输出文件路径
input_file="input.txt"
output_file="output.txt"

# 检查输入文件是否存在
if [ ! -f "$input_file" ]; then
  echo "输入文件不存在。"
  exit 1
fi

# 处理数据字段
echo "开始处理数据字段..."
# 逐行读取输入文件
while IFS= read -r line; do
  # 提取字段并进行处理
  field1=$(echo "$line" | cut -d',' -f1)
  field2=$(echo "$line" | cut -d',' -f2)
  
  # 将字段1转为大写
  field1_upper=$(echo "$field1" | tr '[:lower:]' '[:upper:]')
  
  # 在字段2末尾添加后缀
  field2_suffix="${field2}_suffix"
  
  # 使用正则表达式匹配替换字段1中的特定模式
  field1_modified=$(echo "$field1_upper" | sed -E 's/(pattern)/replacement/')
  
  # 拼接处理后的字段
  merged_field="$field1_modified,$field2_suffix"
  
  # 将处理后的字段写入输出文件
  echo "$merged_field" >> "$output_file"
done < "$input_file"

echo "数据字段处理完成。"

# 退出脚本
exit 0
