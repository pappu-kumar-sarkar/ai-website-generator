function generateWebsite() {

    let userPrompt = document.getElementById('user_prompt').value;
    let category = document.getElementById('category').value;
    let design = document.getElementById('design').value;

    console.log(userPrompt, category, design);

    if (!userPrompt || !category || !design) {
        alert("Please fill all fields");
        return;
    }

    document.getElementById('result').innerHTML =
        "<p style='color:white; text-align:center; margin-top:30px;'>Generating website... Please wait...</p>";

    fetch('/generateWithGemini', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            user_prompt: userPrompt,
            category: category,
            design: design
        })
    })
    .then(res => res.json())
    .then(data => {

        // 🔥 If backend sends error
        if (!data.status) {
            document.getElementById('result').innerHTML =
                "<p style='color:red; text-align:center;'>Something went wrong!</p>";
            return;
        }

        // 🔥 Professional Preview Render
        document.getElementById('result').innerHTML =
            "<iframe id='previewFrame' style='width:100%; height:650px; border:none; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,0.4); background:white;'></iframe>";

        let iframe = document.getElementById('previewFrame');
        iframe.contentDocument.open();
        iframe.contentDocument.write(data.html);
        iframe.contentDocument.close();
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById('result').innerHTML =
            "<p style='color:red; text-align:center;'>Something went wrong!</p>";
    });
}