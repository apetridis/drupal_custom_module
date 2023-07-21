# Custom module Template

This repository provides a template for creating a custom module in Drupal. The template includes three different components:

- Controller: The controller handles specific functionality for a particular URL.
- Webform Handler: The webform handler manages specific requests from webforms and needs to be initialized for each webform that uses it.
- REST: The REST component handles API requests like POST, GET, etc.

## Installation 

To install the module, follow these steps:

- Create a specific folder inside the Drupal configuration, and ensure the path is /modules/custom/custom_template.
- Rename all instances of custom_template to match your desired module name throughout the files.
- You can also clone this repository inside the specified location and update the names accordingly.
- Follow <a href="https://drupal.docs.cern.ch/development/custom-modules#installing-modules-via-webdav" target="_blank">these</a> instructions to install the module in Drupal.

## Usage

After installing the module:
1. The controller will work out of the box.
2. For the webform handler, navigate to "Email/Handlers" in the Settings tab of the webform where you want to implement it, and add it from there.
3. To use the REST resource, follow these steps:
    1. Enable the "RESTful Web Services" module from the Extend list (if not already enabled).
    2. Install and enable the <a href="https://www.drupal.org/project/restui" target="_blank"> "REST UI"</a> module.
    3. Go to "Configuration -> Web services -> REST" and enable your REST API. Check if any pre-existing API fits your needs before creating a new one.

## Using the REST API from a page

- Example for the GetExample:

```
<h3 id="get_answer">&nbsp;</h3>
<script>
try {
    var requestOptions = {
    method: 'GET',
    redirect: 'follow'
    };
    var cookie;
    fetch("https://solvay-education-programme.web.cern.ch/session/token?_format=json", requestOptions)
    .then(response => response.text())
    .then(result => cookie = result)
    .catch(error => console.log('error', error));

    fetch('https://solvay-education-programme.web.cern.ch/get/parameter_1/parameter_2/?_format=json')
                        .then(response => response.json())    
                        .then(data => {                 
                                document.getElementById("get_answer").innerHTML = data;
    });  
} catch (error) {
    <!-- Don't give the error on the production :D-->
    console.log(error);
};
</script>
```

- Example for PostExample:

```
try {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("X-CSRF-TOKEN", cookie);
    data = {};
    data["something"] = "some_data";
    var raw = JSON.stringify(data);
    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    };
    fetch("https://solvay-education-programme.web.cern.ch/post/something?_format=json", requestOptions)
        .then(response => response.text())
        .catch(error => console.log('error', error));
} catch (error) {
    <!-- Don't give the error on the production :D-->
    console.log(error);
};
```

## Tips for debugging

**Before troubleshooting any issues, always clear the cache from "Configuration -> Development -> Performance -> Clear all caches." This step can often resolve problems effectively.**


