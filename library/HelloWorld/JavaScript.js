// 声明一个变量并赋值
let greeting = 'Hello, World!';

// 输出变量的值到控制台
console.log(greeting);

// 定义一个函数
function addNumbers(a, b) {
  return a + b;
}

// 调用函数并输出结果到控制台
let sum = addNumbers(3, 5);
console.log('Sum:', sum);

// 使用条件语句
let age = 25;
if (age >= 18) {
  console.log('成年人');
} else {
  console.log('未成年人');
}

// 使用循环语句
for (let i = 1; i <= 5; i++) {
  console.log(i);
}

// 创建一个对象
let person = {
  name: 'John',
  age: 30,
  profession: 'Developer'
};

// 访问对象属性并输出到控制台
console.log('Name:', person.name);
console.log('Age:', person['age']);

// 使用数组
let fruits = ['Apple', 'Banana', 'Orange'];

// 遍历数组并输出每个元素到控制台
for (let fruit of fruits) {
  console.log(fruit);
}

// 使用事件监听器
let button = document.getElementById('myButton');
button.addEventListener('click', function() {
  console.log('Button clicked!');
});

// 异步操作
setTimeout(function() {
  console.log('异步操作完成！');
}, 2000);
