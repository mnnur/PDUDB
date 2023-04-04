const getCodeButton = document.getElementById('getCode');

getCodeButton.addEventListener("click", getCodeRequest);

function getCodeRequest(){
    const resetPasswordEmail = document.getElementById('resetPasswordEmail');
    const email = resetPasswordEmail.value;
    const data = {
        email: email,
      };
      
      fetch('/resetpassword/tokenrequest', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(() => requestCooldown(60))
      .catch(error => console.error(error));
}

function requestCooldown(seconds){
    getCodeButton.disabled = true;
    let remainingSeconds = seconds;

    getCodeButton.innerText = `Please wait ${remainingSeconds} seconds...`;

    const countdownInterval = setInterval(() => {
        remainingSeconds--;
        getCodeButton.innerText = `Please wait ${remainingSeconds} seconds...`;
        if (remainingSeconds === 0) {
            clearInterval(countdownInterval);
            getCodeButton.innerText = "Get code";
            getCodeButton.disabled = false; // Re-enable the button
        }
    }, 1000);
}
