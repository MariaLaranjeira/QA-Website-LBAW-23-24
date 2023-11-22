function addEventListeners() {

    /*
    let questionCreators = document.querySelector('button.question form.new_question');
    if (questionCreators != null)
      questionCreators.addEventListener('submit', sendCreateQuestionRequest);


    let questionDeleters = document.querySelectorAll();
    [].forEach.call(questionDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteQuestionRequest);
    });
    */

    let answerCreators = document.querySelectorAll('article.card form.new_answer');
    [].forEach.call(answerCreators, function(creator) {
      creator.addEventListener('submit', sendCreateAnswerRequest);
    });
  }
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
  function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
  
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }

  /*
  function createAnswer(answer) {
    let new_answer = document.createElement('li');
    new_answer.classList.add('answer');
    new_answer.setAttribute('data-id', answer.id);
    new_answer.innerHTML = `
    <label>
       <span>${answer.description}</span><a href="#" class="delete">&#10761;</a>
    </label>
    `;

    //new_answer.querySelector('input').addEventListener('change', sendAnswerUpdateRequest);
    //new_answer.querySelector('a.delete').addEventListener('click', sendDeleteAnswerRequest);

    return new_answer;
  }
  */
  
  addEventListeners();
  