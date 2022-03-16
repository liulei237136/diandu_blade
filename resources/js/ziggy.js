const Ziggy = {"url":"http:\/\/localhost:8000","port":8000,"defaults":{},"routes":{"debugbar.openhandler":{"uri":"_debugbar\/open","methods":["GET","HEAD"]},"debugbar.clockwork":{"uri":"_debugbar\/clockwork\/{id}","methods":["GET","HEAD"]},"debugbar.assets.css":{"uri":"_debugbar\/assets\/stylesheets","methods":["GET","HEAD"]},"debugbar.assets.js":{"uri":"_debugbar\/assets\/javascript","methods":["GET","HEAD"]},"debugbar.cache.delete":{"uri":"_debugbar\/cache\/{key}\/{tags?}","methods":["DELETE"]},"admin.auth.users.index":{"uri":"admin\/auth\/users","methods":["GET","HEAD"]},"admin.auth.users.create":{"uri":"admin\/auth\/users\/create","methods":["GET","HEAD"]},"admin.auth.users.store":{"uri":"admin\/auth\/users","methods":["POST"]},"admin.auth.users.show":{"uri":"admin\/auth\/users\/{user}","methods":["GET","HEAD"]},"admin.auth.users.edit":{"uri":"admin\/auth\/users\/{user}\/edit","methods":["GET","HEAD"]},"admin.auth.users.update":{"uri":"admin\/auth\/users\/{user}","methods":["PUT","PATCH"]},"admin.auth.users.destroy":{"uri":"admin\/auth\/users\/{user}","methods":["DELETE"]},"admin.auth.roles.index":{"uri":"admin\/auth\/roles","methods":["GET","HEAD"]},"admin.auth.roles.create":{"uri":"admin\/auth\/roles\/create","methods":["GET","HEAD"]},"admin.auth.roles.store":{"uri":"admin\/auth\/roles","methods":["POST"]},"admin.auth.roles.show":{"uri":"admin\/auth\/roles\/{role}","methods":["GET","HEAD"]},"admin.auth.roles.edit":{"uri":"admin\/auth\/roles\/{role}\/edit","methods":["GET","HEAD"]},"admin.auth.roles.update":{"uri":"admin\/auth\/roles\/{role}","methods":["PUT","PATCH"]},"admin.auth.roles.destroy":{"uri":"admin\/auth\/roles\/{role}","methods":["DELETE"]},"admin.auth.permissions.index":{"uri":"admin\/auth\/permissions","methods":["GET","HEAD"]},"admin.auth.permissions.create":{"uri":"admin\/auth\/permissions\/create","methods":["GET","HEAD"]},"admin.auth.permissions.store":{"uri":"admin\/auth\/permissions","methods":["POST"]},"admin.auth.permissions.show":{"uri":"admin\/auth\/permissions\/{permission}","methods":["GET","HEAD"]},"admin.auth.permissions.edit":{"uri":"admin\/auth\/permissions\/{permission}\/edit","methods":["GET","HEAD"]},"admin.auth.permissions.update":{"uri":"admin\/auth\/permissions\/{permission}","methods":["PUT","PATCH"]},"admin.auth.permissions.destroy":{"uri":"admin\/auth\/permissions\/{permission}","methods":["DELETE"]},"admin.auth.menu.index":{"uri":"admin\/auth\/menu","methods":["GET","HEAD"]},"admin.auth.menu.store":{"uri":"admin\/auth\/menu","methods":["POST"]},"admin.auth.menu.show":{"uri":"admin\/auth\/menu\/{menu}","methods":["GET","HEAD"]},"admin.auth.menu.edit":{"uri":"admin\/auth\/menu\/{menu}\/edit","methods":["GET","HEAD"]},"admin.auth.menu.update":{"uri":"admin\/auth\/menu\/{menu}","methods":["PUT","PATCH"]},"admin.auth.menu.destroy":{"uri":"admin\/auth\/menu\/{menu}","methods":["DELETE"]},"admin.auth.logs.index":{"uri":"admin\/auth\/logs","methods":["GET","HEAD"]},"admin.auth.logs.destroy":{"uri":"admin\/auth\/logs\/{log}","methods":["DELETE"]},"admin.handle-form":{"uri":"admin\/_handle_form_","methods":["POST"]},"admin.handle-action":{"uri":"admin\/_handle_action_","methods":["POST"]},"admin.handle-selectable":{"uri":"admin\/_handle_selectable_","methods":["GET","HEAD"]},"admin.handle-renderable":{"uri":"admin\/_handle_renderable_","methods":["GET","HEAD"]},"admin.login":{"uri":"admin\/auth\/login","methods":["GET","HEAD"]},"admin.logout":{"uri":"admin\/auth\/logout","methods":["GET","HEAD"]},"admin.setting":{"uri":"admin\/auth\/setting","methods":["GET","HEAD"]},"admin.home":{"uri":"admin","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"]},"password.email":{"uri":"password\/email","methods":["POST"]},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"password\/reset","methods":["POST"]},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"]},"verification.notice":{"uri":"email\/verify","methods":["GET","HEAD"]},"verification.verify":{"uri":"email\/verify\/{id}\/{hash}","methods":["GET","HEAD"]},"verification.resend":{"uri":"email\/resend","methods":["POST"]},"home":{"uri":"home","methods":["GET","HEAD"]},"users.show":{"uri":"users\/{user}","methods":["GET","HEAD"],"bindings":{"user":"id"}},"users.edit":{"uri":"users\/{user}\/edit","methods":["GET","HEAD"],"bindings":{"user":"id"}},"users.update":{"uri":"users\/{user}","methods":["PUT","PATCH"],"bindings":{"user":"id"}},"repositories.index":{"uri":"repositories","methods":["GET","HEAD"]},"repositories.create":{"uri":"repositories\/create","methods":["GET","HEAD"]},"repositories.store":{"uri":"repositories","methods":["POST"]},"repositories.edit":{"uri":"repositories\/{repository}\/edit","methods":["GET","HEAD"]},"repositories.update":{"uri":"repositories\/{repository}","methods":["PUT","PATCH"]},"repositories.destroy":{"uri":"repositories\/{repository}","methods":["DELETE"],"bindings":{"repository":"id"}},"repositories.show":{"uri":"repositories\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repository_setting.show":{"uri":"repository_setting\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repository_comments.show":{"uri":"repository_comments\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repository_audio.show":{"uri":"show_audio\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repository_audio.edit":{"uri":"edit_audio\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repositories.edit_description":{"uri":"edit_description\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repositories.update_description":{"uri":"repositories\/{repository}\/update_descritpion","methods":["PUT"],"bindings":{"repository":"id"}},"repositories.update_name":{"uri":"repositories\/{repository}\/update_name","methods":["PUT"],"bindings":{"repository":"id"}},"repositories.init":{"uri":"init\/{repository}\/{slug?}","methods":["GET","HEAD"],"bindings":{"repository":"id"}},"repositories.upload_image":{"uri":"upload_image","methods":["POST"]},"repositories.upload_audio":{"uri":"upload_audio","methods":["POST"]},"comments.store":{"uri":"comments","methods":["POST"]},"comments.destroy":{"uri":"comments\/{comment}","methods":["DELETE"],"bindings":{"comment":"id"}},"notifications.index":{"uri":"notifications","methods":["GET","HEAD"]},"commits.store":{"uri":"repositories\/{repository}\/commits","methods":["POST"],"bindings":{"repository":"id"}}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
