//テンプレートファイルURL
var url  = "/wow/common/js/ckeditor/plugins/templates/templates/html/";

//loadDataでテンプレートファイルを取得して変数に代入します。
//ファイル名は適宜変更してください。
//テンプレートを追加する場合はここにファイル名を追加してください。
var tpl1 = loadData(url + "template1.html");
var tpl2 = loadData(url + "template1.html");
var tpl3 = loadData(url + "template1.html");

//Ajax同期通信で外部テンプレートを読み込んでデータを返します。
function loadData(url) {
	//XMLHttpRequestオブジェクト初期化
	var getData = new XMLHttpRequest();
	//同期通信リクエスト作成
	getData.open("GET", url, false);
	//リクエスト送信
	getData.send(null);
	//レスポンスデータを取得して値を返す
	return(getData.responseText);
}

//CKEditorの「テンプレート」をクリックしたとき表示される内容をJSON形式で作成
//テンプレートを追加する場合はここにテンプレートの情報を追加してください。
CKEDITOR.addTemplates("default", {
	imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates") + "templates/images/"),
	templates:[{
		title: "テンプレート1",
        image: "template1.gif",
        description: "テンプレート1",
        html: tpl1
	},
	{
		title: "テンプレート2",
        image: "template1.gif",
        description: "テンプレート2",
        html: tpl1
	},
	{
		title: "テンプレート3",
        image: "template1.gif",
        description: "テンプレート3",
        html: tpl1
	}]
});