import axios from 'axios'

/**
 * Responsible for all HTTP requests.
 */
export default {
	// posts_get(url, page){
	// 	axios.post(url+'?page='+page, {})
	// 	.then(res => {
	// 		return res
	// 	}).catch(error => {
	// 		return error
	// 	});
	// }

	/**
	 * 現在時刻取得
	 * @return 現在時刻
	 */
	get_nowdatetime(){
		var Nowymdhms　=　new Date();
		var NowYear = Nowymdhms.getYear();
		var NowMon = Nowymdhms.getMonth() + 1;
		var NowDay = Nowymdhms.getDate();
		var NowWeek = Nowymdhms.getDay();
		var NowHour = Nowymdhms.getHours();
		var NowMin = Nowymdhms.getMinutes();
		var NowSec = Nowymdhms.getSeconds();
		var Week = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
		if(NowHour < 10){
			NowHour = "0"+NowHour;
		}
		if(NowMin < 10){
			NowMin = "0"+NowMin;
		}

		return NowYear+"-"+NowMon+"-"+NowDay+" "+NowHour+":"+NowMin+":"+NowSec;
	}
}