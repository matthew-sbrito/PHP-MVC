class Spinner {
  constructor() {
    this.component = document.querySelector(".spinner");
    this.createElement();
  }
  createElement() {
    const div = document.createElement("div")
    const one = document.createElement("div");
    one.className = "one";
    const two = document.createElement("div");
    two.className = "two";
    const three = document.createElement("div");
    three.className = "three";
    const four = document.createElement("div");
    four.className = "four";
    const span = document.createElement("span");
    span.innerHTML = "Carregando...";

    three.append(four);
    two.append(three);
    one.append(two);
    
    div.append(one)
    div.append(span)

    this.component.append(div);
  }
  show() {
    this.component.style.display = "flex";
  }
  hide() {
    this.component.style.display = "none";
  }
}

const spinner = new Spinner();
setTimeout(() =>{
  spinner.hide();
}, 2000)



class Toastr {
  constructor() {
    this.component = document.querySelector(".toastr");
    this.component.style.display = "flex";
  }

  createElement(config) {
    const element = document.createElement("div");
    element.className = "toastr-c";
    element.style.backgroundColor = config.cor;

    const icon = document.createElement("i");
    icon.className = config.icon;

    const span = document.createElement("span");
    span.innerHTML = config.msg;

    const div = document.createElement("div");

    element.appendChild(icon);
    element.appendChild(span);
    element.appendChild(div);

    return element;
  }

  warning(msg) {
    const config = {
      cor: "rgba(249, 200, 78, 0.8)",
      icon: "fas fa-exclamation-triangle",
      msg,
    };
    const element = this.createElement(config);
    this.setMessage(element);
  }
  error(msg) {
    const config = {
      cor: "rgba(240, 14, 14, 0.8)",
      icon: "fas fa-ban",
      msg,
    };
    const element = this.createElement(config);
    this.setMessage(element);
  }
  success(msg, time) {
    const config = {
      cor: "rgba(34, 167, 34, 0.8)",
      icon: "far fa-check-circle",
      msg,
    };

    const element = this.createElement(config);
    this.setMessage(element);
    this.hideTime(time)
  }

  setMessage(element) {
    this.component.append(element);
  }
  hideTime(second) {
    setTimeout(() => {
      for (let element of this.component.children) {
        element.remove();
      }
    }, second * 1000);
  }
  hide() {
    for (let element of this.component.children) {
      element.remove();
    }
  }
}

const toastr = new Toastr();
toastr.success('Bem vindo!', 3)

// setTimeout(()=>{
//   document.querySelector('.toastr2').setAttribute("hidden",true)
// },4000)