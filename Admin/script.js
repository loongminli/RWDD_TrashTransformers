function checkStaffForm() {
    var form = document.forms["staffForm"];
    var fields = form.querySelectorAll("[required]");

    for (var i = 0; i < fields.length; i++) {
        if (fields[i].value.trim() == "") {
            alert("Please fill in all required information!");
            fields[i].focus();
            return false;
        }
    }
    return true;
}

function confirmDelete(type) {
    if (type == "staff") {
        return confirm("Are you sure you want to delete this staff?");
    } else if (type == "challenge") {
        return confirm("Are you sure you want to delete this challenge?");
    } else if (type == "reward") {
        return confirm("Are you sure you want to delete this reward?");
    } else if (type == "challenge_reward") {
        return confirm("Are you sure you want to remove this assigned reward?");
    }
    return false;
}

function showMessage() {
    var url = window.location.href;

    if (url.indexOf("error=duplicate_staff") != -1) {
        alert("Staff ID already exists!");
    } else if (url.indexOf("error=assigned_reward") != -1) {
        alert("This challenge already has an assigned reward. Cannot delete the challenge. Please remove the assigned reward first.");
    } else if (url.indexOf("error=assigned_challenge") != -1) {
        alert("This reward is already assigned to a challenge. Cannot delete the reward. Please remove the assigned reward first.");
    } else if (url.indexOf("error=duplicate_assignment") != -1) {
        alert("This challenge or reward is already assigned. Please select another one.");
    } else if (url.indexOf("error=database") != -1) {
        alert("Something wrong. Please try again!");
    }

    else if (url.indexOf("staff_manage.php") != -1) {
        if (url.indexOf("success=add") != -1) {
            alert("Staff added successfully.");
        } else if (url.indexOf("success=edit") != -1) {
            alert("Staff updated successfully.");
        } else if (url.indexOf("success=delete") != -1) {
            alert("Staff deleted successfully.");
        }
    }

    else if (url.indexOf("user_manage.php") != -1) {
        if (url.indexOf("success=update") != -1) {
            alert("User status updated successfully.");
        }
    }

    else if (url.indexOf("challenge_manage.php") != -1) {
        if (url.indexOf("success=add") != -1) {
            alert("Challenge added successfully.");
        } else if (url.indexOf("success=edit") != -1) {
            alert("Challenge updated successfully.");
        } else if (url.indexOf("success=delete") != -1) {
            alert("Challenge deleted successfully.");
        }
    }

    else if (url.indexOf("reward_manage.php") != -1) {
        if (url.indexOf("success=add") != -1) {
            alert("Reward added successfully.");
        } else if (url.indexOf("success=edit") != -1) {
            alert("Reward updated successfully.");
        } else if (url.indexOf("success=delete") != -1) {
            alert("Reward deleted successfully.");
        }
    }

    else if (url.indexOf("challenge_reward_manage.php") != -1) {
        if (url.indexOf("success=add") != -1) {
            alert("Reward assigned successfully!");
        } else if (url.indexOf("success=delete") != -1) {
            alert("Assigned reward removed successfully!");
        }
    }
}
