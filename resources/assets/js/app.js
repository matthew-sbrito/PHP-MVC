class Observable {
  constructor() {
    this.observers = [];
  }
  subscribe(element) {
    this.observers.push(element);
  }
  unsubscribe(element) {
    this.observers = this.observers.filter(
      (subscriber) => subscriber !== element
    );
  }
  notify(state) {
    this.observers.forEach((observer) => {
      observer(state);
    });
  }
  notifyAll() {
    this.observers.forEach((observer) => {
      observer();
    });
  }
}

class App {
  constructor() {
    this.Observer = new Observable();
    this.callback = [
  
    ];
  }
  setObserver = (callback) => {
    this.Observer.subscribe(callback);
  };
  run() {
    this.callback.forEach((c) => {
      this.setObserver(c);
    });
  }
}

const app = new App();
app.run();
app.Observer.notifyAll();
