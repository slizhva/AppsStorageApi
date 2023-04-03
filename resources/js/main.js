document.addEventListener("DOMContentLoaded", function () {

    const $enableDangerousActionForm = $('#enable-dangerous-action-form')
    $enableDangerousActionForm.on('submit', (e) => {
        e.preventDefault()
        const dangerousKey = $enableDangerousActionForm.find("input[name='key']").val()
        $('.dangerous-action-key-value').each((index, el) => {
            $(el).val(dangerousKey)
        })
        $('.dangerous-action-button').removeAttr("disabled")
    });

    const $copyLinkButtons = $('.copyLinkButton')
    if ($copyLinkButtons.length > 0) {
        navigator.permissions.query({name: "clipboard-write"}).then((result) => {
            if (result.state === "granted" || result.state === "prompt") {
                $copyLinkButtons.on('click', (e) => {
                    const $copyLinkButton = $(e.target)
                    const $dataLinkButton = $copyLinkButton.parent()
                    navigator.clipboard.writeText($dataLinkButton.find('.dataLinkText').text())
                    $copyLinkButton.val('Copied!')
                    setTimeout(() => {
                        $copyLinkButton.val('Copy Link')
                    }, 2000)
                })

                $copyLinkButtons.show()
            }
        });
    }
})
