function generateProject() {

    let userPrompt = document.getElementById("user_prompt").value;

    if (!userPrompt) {
        alert("Please enter prompt");
        return;
    }

    document.getElementById("result").innerHTML =
        "<p style='color:white; text-align:center;'>Generating...</p>";

    fetch("/generateComponentProject", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            user_prompt: userPrompt
        })
    })
    .then(res => res.json())
    .then(data => {

        if (!data.status) {
            document.getElementById("result").innerHTML =
                "<p style='color:red; text-align:center;'>Error occurred</p>";
            return;
        }

        let json = data.data;

        document.getElementById("result").innerHTML = `
            <div class="preview-card">
                <h2>${json.header.hero_title}</h2>
                <p>${json.header.hero_tagline}</p>
                <hr>
                <p>${json.about_us.about_text}</p>
                <hr>
                <p>${json.footer.contact_text}</p>
            </div>
        `;
    })
    .catch(error => {
        console.error(error);
        document.getElementById("result").innerHTML =
            "<p style='color:red; text-align:center;'>Something went wrong!</p>";
    });
}