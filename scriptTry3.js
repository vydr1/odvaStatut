//let email = document.getElementById("email");
alert(email.value); 

const form = document.forms["form"];
const formArr = Array.from(form);
const validFormArr = [];
const button = form.elements["button"];

//alert(formArr.length);

formArr.forEach((el) => {
  if (el.hasAttribute("data-reg")) {
    el.setAttribute("is-valid", "0");
    validFormArr.push(el);
  }
});

form.addEventListener("input", inputHandler);
form.addEventListener("submit", formCheck);


function inputHandler({ target }) {
  if (target.hasAttribute("data-reg")) {
    inputCheck(target);
  }
}

async function test(){
    return await fetch("sendmail.php");
}

function inputCheck(el) {
  const inputValue = el.value;
  const inputReg = el.getAttribute("data-reg");
  const reg = new RegExp(inputReg);
  if (reg.test(inputValue)) {
    el.setAttribute("is-valid", "1");
    el.style.border = "2px solid rgb(0, 196, 0)";
  } else {
    el.setAttribute("is-valid", "0");
    el.style.border = "2px solid rgb(255, 0, 0)";
  }
}

function formCheck(e) {
    //alert("sdsdsds");
  e.preventDefault();
  const allValid = [];
  //alert(validFormArr[0]);
  validFormArr.forEach((el) => {
    allValid.push(el.getAttribute("is-valid"));
  });
  const isAllValid = allValid.reduce((acc, current) => {
    return acc && current;
  });
  if (!Boolean(Number(isAllValid))) {
    alert("Заполните поля правильно!");
    return;
  }
  formSubmit();
}

async function formSubmit() {
    const data = serializeForm(form);
    alert("отправка");
    
  }


