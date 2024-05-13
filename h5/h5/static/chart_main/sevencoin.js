localStorage.removeItem("tradingview.chartproperties");
$(function () {
    let light = {
        'volumePaneSize': "small",//large, medium, small, tiny
        "paneProperties.background": "#ffffff",
        "paneProperties.vertGridProperties.color": "#dcdee0",
        "paneProperties.horzGridProperties.color": "#dcdee0",
        "scalesProperties.backgroundColor": "#ffffff",
        "scalesProperties.lineColor": "#dcdee0",
        "scalesProperties.textColor": "#333",
        "scalesProperties.fontSize": 9,
        "mainSeriesProperties.style": 1,
        "paneProperties.legendProperties.showSeriesOHLC": true,
        "mainSeriesProperties.candleStyle.upColor": '#4daa90',
        "mainSeriesProperties.candleStyle.downColor": '#c15465',
        "mainSeriesProperties.candleStyle.borderUpColor": '#4daa90',
        "mainSeriesProperties.candleStyle.borderDownColor": '#c15465'
    }

    let dark = {
        'volumePaneSize': "small",//large, medium, small, tiny
        "paneProperties.background": "#2b2b37",
        "paneProperties.vertGridProperties.color": "#49495F",
        "paneProperties.horzGridProperties.color": "#49495F",
        "scalesProperties.backgroundColor": "#2b2b37",
        "scalesProperties.textColor": "#fff",
        "scalesProperties.lineColor": "#49495F",
        "scalesProperties.fontSize": 9,
        "mainSeriesProperties.style": 1,
        "paneProperties.legendProperties.showSeriesOHLC": true,
        "mainSeriesProperties.candleStyle.upColor": '#4daa90',
        "mainSeriesProperties.candleStyle.downColor": '#c15465',
        "mainSeriesProperties.candleStyle.borderUpColor": '#4daa90',
        "mainSeriesProperties.candleStyle.borderDownColor": '#c15465'
    }
    let tvStyle = {
        light,
        dark
    }
    class Datafeed {
        constructor(vm) {
            this.self = vm;
        }
        onReady(callback) {
            setTimeout(()=>{
                callback({
                    supports_search: false,
                    supports_group_request: false,
                    supported_resolutions: this.self.resolutions,
                    supports_marks: true,
                    supports_timescale_marks: true,
                    supports_time: true
                })
            },30)
        }
        resolveSymbol(symbolName, onSymbolResolvedCallback, onResolveErrorCallback) {
            setTimeout(()=>{
                let data = this.defaultSymbol()
                if (this.self.resolveSymbol) {
                    this.self.resolveSymbol((res) => {
                        onSymbolResolvedCallback(Object.assign(data, res))
                    })
                } else {
                    onSymbolResolvedCallback(data)
                }
            },60)
        }
        getBars() {
            this.self.getBars(...arguments)
        }

        subscribeBars() {
            this.self.subscribeBars(...arguments)
        }
        unsubscribeBars() {

        }
        defaultSymbol() {
            return {
                'timezone': 'Asia/Shanghai',
                'minmov': 1,
                'minmov2': 0,
                'fractional': true,
                //设置周期
                'session': '24x7',
                'has_intraday': true,
                'has_no_volume': false,
                //设置是否支持周月线
                "has_daily": true,
                //设置是否支持周月线
                "has_weekly_and_monthly": true,
                //设置精度  100表示保留两位小数   1000三位   10000四位
                'pricescale': 10000

            };
        }
    }


    class Page {
        constructor() {
            this.datafeed = undefined;
            this.page = 1;
            this.onRealtimeCallback = undefined;
            this.TView = undefined;
            this.interval = this.getQuery('interval');
            this.symbolName = this.getQuery('symbol');
            this.theme = this.getQuery('theme') || 'dark';
            this.lang = this.getQuery('lang') || 'en';
            this.resolutions = this.getQuery('resolutions') || ["5", "15", "30", "60","240", "1D", "1W", "1M"];
            this.isLoad = false;
            this.url = this.getQuery('getLinkUrl');
            this.TVID = "tradingview_10798345";
            this.Ws = undefined;
            this.msg = '';
            this.contract = this.getQuery('contract');
            this.init();
            this.studies = []; //配置项
            this.tvBars = [];
        }
        // 获取路劲上的参数
        getQuery(name) {
            let str = window.location.search.replace('?','')
            let data = Qs.parse(str)||{}
            return data[name]
        }
        // 初始化
        init() {
            this.linkSocket()
            // 数据模型
            this.datafeed = new Datafeed(this)
            // 初始化图表
            this.TView = new TradingView.widget({
                debug: true,
                fullscreen: false,
                autosize: true,
                interval: this.interval,
                timezone: "Asia/Shanghai",
                theme: "Dark", // 自定义主题
                height:500,
                // style: "1",
                library_path: "./chart_main/",
                datafeed: this.datafeed,
                // datafeed: {},
                locale: this.chartLang(),
                toolbar_bg: this.theme == "light" ? "#fff" : "#2b2b37",
                // toolbar_bg: "#2b2b37",
                enable_publishing: false,
                withdateranges: false,
                hide_side_toolbar: false,
                allow_symbol_change: true,
                show_popup_button: true,
                hideideas: true,
                studies_overrides: {},
                container_id: "tradingview_10798345",
                enabled_features:[
                    'dont_show_boolean_study_arguments',
                ],
                disabled_features: [
                    "header_symbol_search",
                    "header_compare",
                    "control_bar",
                    "main_series_scale_menu",
                    "volume_force_overlay",
                    "header_resolutions",
                    "legend_context_menu",
                    "symbol_search_hot_key",
                    "symbol_info",
                    "pane_context_menu",
                    "header_widget_dom_node",
                    'timeframes_toolbar',
                    'header_indicators',
                    'widget_logo',
                    'header_chart_type'

                ],
                overrides: tvStyle[this.theme],
                custom_css_url: this.theme == "light" ? "light-chart.css" : "chart.css",
                // custom_css_url: "chart.css",
            });
            this.TView.onChartReady(() => {
                this.createStudy()
                this.TView.chart().crossHairMoved(({time, price}) => {
                    const resolutionTime = this.getResolutionTime();
                    const fTime = Math.floor(time/resolutionTime)*resolutionTime;
                    this.showKlineQuoter(fTime);
                })
            });
        }
        upsertTvBars(isFirstCall, bars) {
            if (isFirstCall) {
                this.tvBars = [];
            }
            bars.forEach((bar) => {
                if (this.tvBars.length === 0 || !this.tvBars.find(o => o.time === bar.time)) {
                    this.tvBars.push(bar);
                }
            })
            this.tvBars.sort((a,b) => {
                if (a.time < b.time) return -1;
                if( a.time > b.time ) return 1;
                return 0;
            });
        }
        showKlineQuoter(time) {
            $('iframe').mousemove(function(e){
              console.log('0000')
            });
            if (this.tvBars.length === 0) return;
            const {from, to} = this.TView.chart().getVisibleRange();
            // const aa = this.TView.chart().getVisiblePriceRange()
            // console.log(from, to,aa)
            const bar = this.tvBars.find(o => o.time  === time*1000);
            if(!bar) return;
            const barTime = bar.time/1000 + 60*60*8;
            const fromSize = barTime - from;
            const toSize = to - barTime;
            const tvQuoter = $($('iframe').contents()[0]).find('#tv-quoter');
            tvQuoter.css({
                visibility: 'visible',
            })
            if (fromSize > toSize) {
                tvQuoter.css({
                    left: '10px',
                    right: 'auto'
                })
            } else {
                tvQuoter.css({
                    right: '10px',
                    left: 'auto'
                })
                tvQuoter.removeClass('left')
            }
            let zhangdiefu=(bar.close-bar.open)/bar.open
            let zhangdiee=bar.close-bar.open
            tvQuoter.find('[data-name="date"]').text(this.timestampToTime(bar.time));
            tvQuoter.find('[data-name="date_lang"]').text(this.lang=='zh-CN'?'时间':'Date');
            tvQuoter.find('[data-name="open"]').text(bar.open);
            tvQuoter.find('[data-name="open_lang"]').text(this.lang=='zh-CN'?'开':'Open');
            tvQuoter.find('[data-name="high"]').text(bar.high);
            tvQuoter.find('[data-name="high_lang"]').text(this.lang=='zh-CN'?'高':'H');
            tvQuoter.find('[data-name="low"]').text(bar.low);
            tvQuoter.find('[data-name="low_lang"]').text(this.lang=='zh-CN'?'低':'L');
            tvQuoter.find('[data-name="close"]').text(bar.close);
            tvQuoter.find('[data-name="close_lang"]').text(this.lang=='zh-CN'?'收':'Close');
            tvQuoter.find('[data-name="volume"]').text((+bar.volume).toFixed());
            tvQuoter.find('[data-name="volume_lang"]').text(this.lang=='zh-CN'?'成交量':'Executed');
            tvQuoter.find('[data-name="zhangdiefu"]').text((zhangdiefu*100).toFixed(2)+'%');
            tvQuoter.find('[data-name="zhangdiefu_lang"]').text(this.lang=='zh-CN'?'涨跌幅':'Change%');
            tvQuoter.find('[data-name="zhangdiefu"]').css('color',zhangdiee>0?'#53b987':'#eb4d5c');
            tvQuoter.find('[data-name="zhangdiee"]').text(zhangdiee.toFixed(4));
            tvQuoter.find('[data-name="zhangdiee_lang"]').text(this.lang=='zh-CN'?'涨跌额':'Change');
            tvQuoter.find('[data-name="zhangdiee"]').css('color',zhangdiee>0?'#53b987':'#eb4d5c');
        }
        timestampToTime(timestamp) {
            const date = new Date(timestamp);
            const yyyy = `${date.getFullYear()}`;
            const yy = `${date.getFullYear()}`.substr(2);
            const MM = `0${date.getMonth() + 1}`.slice(-2);
            const dd = `0${date.getDate()}`.slice(-2);
            const HH = `0${date.getHours()}`.slice(-2);
            const mm = `0${date.getMinutes()}`.slice(-2);


            const resolution = this.TView.chart().resolution();
            let dateStr = ''
            if (resolution === 'D' || resolution === 'W' || resolution === 'M') {
                dateStr =`${yyyy}-${MM}-${dd}`;
            } else {
                dateStr =`${yy}-${MM}-${dd} ${HH}:${mm}`;
            }
            return dateStr
        }
        getResolutionTime() {
            const resolution = this.TView.chart().resolution();
            switch (resolution) {
                case '1':
                    return 60;
                case '5':
                    return 5 * 60;
                case '10':
                    return 10 * 60;
                case '15':
                    return 15 * 60;
                case '30':
                    return 30 * 60;
                case '60':
                    return 60 * 60;
                case '120':
                    return 120 * 60;
                case 'D':
                    return 24 * 60 * 60;
                case 'W':
                    return 7 * 24 * 60 * 60;
                case 'M':
                    return 4 * 7 * 24 * 60 * 60;
            }
            return 1;
        }

        createStudy() {
            let thats = this.TView;
            let id = thats.chart().createStudy('Moving Average', false, true, [5], null, {
              'Plot.color': this.theme == "light" ? "#efc149" : 'rgb(238, 218, 154)',
              'Plot.linewidth': 3
            });
            this.studies.push(id);
            id = thats.chart().createStudy('Moving Average', false, true, [10], null, {
              'Plot.color': this.theme == "light" ? "#7fcec0" : 'rgb(123, 201, 187)',
              'Plot.linewidth': 3
            });
            this.studies.push(id);
            id = thats.chart().createStudy('Moving Average', false, true, [20], null, {
              "plot.color": "rgb(194, 148, 247)",
              'Plot.linewidth': 3
            });
            this.studies.push(id);
          }
        // 连接socket
        linkSocket() {
            // 连接socket
            this.Ws = new Ws(this.getQuery('ws'))
            this.Ws.on('message', (evt) => {
                if (evt.cmd == 'ping') {
                    this.Ws.send({ cmd: 'pong' })
                }
                if (evt.type == 'ping') {
                    this.Ws.send({ cmd: 'pong' })
                }
                //  追加数据
                // console.log(evt,evt.sub ,this.msg)
                if (evt.sub == this.msg) {
                    this.onRealtimeCallback(this.getMap(evt.data))
                }
            })
        }
        // 图表语言映射
        chartLang() {
            switch (this.lang) {
                case "zh-CN":
                    return 'zh';
                case "zh-TW":
                    return 'zh_TW';
                case "tr":
                    return 'tr';
                case "jp":
                    return 'ja';
                case "kor":
                    return 'ko';
                case "de":
                    return 'de_DE';
                case "fra":
                    return 'fr';
                case "it":
                    return 'it';
                case "pt":
                    return 'pt';
                case "spa":
                    return 'es';
                default:
                    return 'en';
            }
        }
        getMap(data) {
            return {
                time: data.id * 1000,
                close: data.close * 1,
                open: data.open * 1,
                high: data.high * 1,
                low: data.low * 1,
                volume: data.vol * 1,
            };
        }
        resolveSymbol(call) {
            // 名称
            call({
                'name': this.symbolName.toLocaleUpperCase(),
                'description': this.symbolName.toLocaleUpperCase(),
                'ticker': this.symbolName.toLocaleUpperCase(),
                'supported_resolutions': this.resolutions
            })
        }
        // 获取数据
        getBars(symbolInfo, resolution, rangeStartDate, rangeEndDate, onDataCallback, onErrorCallback, isFirstCall) {
            let page = this.page > 3 ? 3 : this.page;
            let data = {
                symbol: symbolInfo.name,
                period: this.resolution(resolution),
                form: rangeStartDate,
                to: rangeEndDate,
                size: page * 200,
                zip: 2
            }
            this.page++
            this.isLoad = true
            this.unSub();
            $.get(this.url, data).then(res => {
                let arr = this.unzip(res.data.data).map((item) => {
                    return this.getMap(item);
                });
                this.upsertTvBars(isFirstCall, arr);
                onDataCallback(arr);
                this.msg = this.createMsg()
                this.sub()

            }).catch(err => {
                onDataCallback([]);
            })
        }
        // 解压
        unzip(b64Data) {
            let u8 = atob(b64Data)
            let jiya = pako.inflate(u8)
            let str = this.Uint8ArrayToString(jiya)
            return JSON.parse(str);
        }
        Uint8ArrayToString(fileData){
            var dataString = "";
            for (var i = 0; i < fileData.length; i++) {
              dataString += String.fromCharCode(fileData[i]);
            }

            return dataString

          }
        // 获取传给后台的精度
        resolution(resolution) {
            let T = "";
            if (isNaN(resolution * 1)) {
                T = resolution
                    .replace("D", "day")
                    .replace("W", "week")
                    .replace("M", "mon");
            } else {
                if (resolution > 60) {
                    T = Math.floor(resolution / 60) + "hour";
                } else {
                    T = resolution + "min";
                }
            }
            return T;
        }
        // 获取推送回调
        subscribeBars(symbolInfo,
            resolution,
            onRealtimeCallback,
            subscriberUID,
            onResetCacheNeededCallback) {
            this.onRealtimeCallback = onRealtimeCallback;
            if (!this.symbolName) {
                setTimeout(() => {
                    onResetCacheNeededCallback();
                }, 100);
            }
        }
        getSymbol(name) {
            return name.split("/").join("").toLowerCase();
        }
        // 生成订阅数据
        createMsg() {
            console.log(this.contract)
            console.log(`swapKline_${this.symbolName}_${this.resolution(this.interval)}`)
            if (this.contract) {
                return `swapKline_${this.symbolName}_${this.resolution(this.interval)}`
            } else {

                return `Kline_${this.getSymbol(this.symbolName)}_${this.resolution(this.interval)}`
            }
        }
        // 订阅消息
        sub() {
            this.Ws.send({
                cmd: "sub",
                msg: this.msg
            })
        }
        // 取消订阅
        unSub() {
            if (!this.msg) return;
            this.Ws.send({
                cmd: "unsub",
                msg: this.msg
            })
        }
    }
    new Page()
})
