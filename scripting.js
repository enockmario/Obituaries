function validateForm() {
    let name = document.forms["obituaryForm"]["name"].value;
    let dob = document.forms["obituaryForm"]["date_of_birth"].value;
    let dod = document.forms["obituaryForm"]["date_of_death"].value;
    let content = document.forms["obituaryForm"]["content"].value;
    let author = document.forms["obituaryForm"]["author"].value;

    if (name == "" || dob == "" || dod == "" || content == "" || author == "") {
        alert("All fields must be filled out");
        return false;
    }
    return true;
}
