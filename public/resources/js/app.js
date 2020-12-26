function loadAsyncFonts()
{
    WebFont.load({
        google: {
          families: ['Montserrat:300,400,600,700',]
        }
      });
}

function onSubmitForm()
{
  const input = document.getElementById("urlPointing");
  createURL(input);
  return false;
}

function createURL(urlPointing)
{
  let http = new XMLHttpRequest();
  //API Data - Key is free for use
  let key = "ebdf69096315c877539c5df93316798fbd44b72c6a7a8833caa203bb2ca0bf01";
  let url = "http://localhost/Quarks/public/api/url";
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json");
  http.setRequestHeader("X-Auth", key);
  http.onload = function(e) {
    if (this.status == 200) {
      const form = document.querySelector(".mainForm form");
      const congratulation = document.querySelector(".congratulation");

      form.classList.add("hideForm"); 
      congratulation.classList.add("hideDefault");
      congratulation.children[1].innerHTML = JSON.parse(this.response)[0].QuarksURL;

    }
  };
  let data = JSON.stringify({"PointingURL": urlPointing.value});
  
  http.send(data);
}

function copyContent(){
  const btn = document.getElementById("copyContent");

  btn.addEventListener('click', async event => {
    if (!navigator.clipboard) {
      // Clipboard API not available
      return
    }
  const content = document.querySelector(".congratulation").children[1].innerText;
    try {
      await navigator.clipboard.writeText(content)
      event.target.textContent = 'Copied to clipboard';
    } catch (err) {
      console.error('Failed to copy!', err)
    }
  });
}

function createAnother(){
  const btn = document.getElementById("createAnother");

  btn.addEventListener('click', async event => {
      const form = document.querySelector(".mainForm form");
      const congratulation = document.querySelector(".congratulation");

      form.classList.remove("hideForm"); 
      congratulation.classList.remove("hideDefault");
      congratulation.children[1].innerHTML = "";
  });
}

window.onload = () => {
    loadAsyncFonts();
    copyContent();
    createAnother();
}



