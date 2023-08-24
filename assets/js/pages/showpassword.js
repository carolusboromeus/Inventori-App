function ShowPassword() {
  var x = document.getElementById("password");
  var y = document.getElementById("new password");
  var z = document.getElementById("confirm password");
  if (x.type === "password") 
  {
    x.type = "text";
  } 
  else 
  {
    x.type = "password";
  }

  if(y.type === "password" || z.type === "password")
  {
    y.type = "text";
    z.type = "text";
  }
  else
  {
    y.type = "password";
    z.type = "password";
  }
}