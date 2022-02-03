import type jQuery from "jquery";

type GlobalThis = typeof globalThis &
  Window & {
    NaN: never;
    Infinity: never;
  };

interface MyGlobal extends GlobalThis {
  ajaxurl: string;
  jQuery: typeof jQuery;
  tb_show(title: string, url: string): boolean;
}

window.addEventListener("load", (_event) => {
  const publishBtn = document.querySelector("#wp-admin-bar-publish-changes");
  const { ajaxurl, jQuery, tb_show } = window as MyGlobal;

  console.log(publishBtn);

  publishBtn?.addEventListener("click", (e) => {
    const target = e.target as HTMLElement;
    e.preventDefault();

    if (target.getAttribute("disabled") !== "true") {
      target.setAttribute("disabled", "true");

      jQuery
        .post(
          ajaxurl,
          {
            action: "dispatch_deploy",
          },
          (resp) => {
            console.log(resp);
            tb_show(
              "Changes were successfully published!",
              "#TB_inline?inlineId=deploy-modal&width=auto"
            );
          }
        )
        .always(() => {
          target.removeAttribute("disabled");
        });
    }
  });
});
