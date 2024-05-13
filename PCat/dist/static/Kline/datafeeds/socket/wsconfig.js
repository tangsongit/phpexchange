var Wsconfig = (function () {

    var WsConfig = function (symbolId, symbolName, symbolType, priceDecimal) {
        // var urls = 'wss://virgox.com/websocket';
        var urls = 'wss://test.virgox.com/websocket';
        this.widgets = null;
        this.socket = new socket(urls);
        this.datafeeds = new datafeeds(this);
        this.symbol = symbolName || "btc/usdt"; // 初始化默认交易对
        this.symbolId = symbolId;
        this.symbolType = symbolType;
        this.interval = localStorage.getItem('tradingview.resolution') || '15';
        this.cacheData = {};
        this.lastTime = null;
        this.pricescale = priceDecimal;
        this.getBarTimer = null;
        this.isLoading = true;
        var that = this;
        this.socket.doOpen()
        this.socket.on('open', function () {
            if (symbolType == 1) {
                if (that.interval <= 43200) { // 1D 以内
                    that.socket.send({
                        request: "history_kline_" + symbolId + "_" + that.interval,
                        sub: "dynamic_kline_" + symbolId + "_" + that.interval,
                    })
                } else if (that.interval == "1D") { // 按钮将interval值设为1D   
                    that.socket.send({
                        request: "history_kline_" + symbolId + "_1440",
                        sub: "dynamic_kline_" + symbolId + "_1440",
                    })
                } else if (that.interval == "1W") {
                    that.socket.send({
                        request: "history_kline_" + symbolId + "_10080",
                        sub: "dynamic_kline_" + symbolId + "_10080",
                    })
                } else if (that.interval == "1M") {
                    that.socket.send({
                        request: "history_kline_" + symbolId + "_43200",
                        sub: "dynamic_kline_" + symbolId + "_43200",
                    })
                }
            } else if (symbolType == 2) {
                if (that.interval <= 43200) {
                    that.socket.send({
                        request: "futures_history_kline_" + symbolId + "_" + that.interval,
                        sub: "futures_dynamic_kline_" + symbolId + "_" + that.interval,
                    })
                } else if (that.interval == "1D") {
                    that.socket.send({
                        request: "futures_history_kline_" + symbolId + "_1440",
                        sub: "futures_dynamic_kline_" + symbolId + "_1440",
                    })
                } else if (that.interval == "1W") {
                    that.socket.send({
                        request: "futures_history_kline_" + symbolId + "_10080",
                        sub: "futures_dynamic_kline_" + symbolId + "_10080",
                    })
                } else if (that.interval == "1M") {
                    that.socket.send({
                        request: "futures_history_kline_" + symbolId + "_43200",
                        sub: "futures_dynamic_kline_" + symbolId + "_43200",
                    })
                }
            }
        })
        this.socket.on('message', that.onMessage.bind(this))
        this.socket.on('close', that.onClose.bind(this))
    };

    WsConfig.prototype.init = function () {
        var resolution = this.interval;
        var chartType = (localStorage.getItem('tradingview.chartType') || '1') * 1;

        var symbol = this.symbol;

        var locale = 'en'; // 

        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        var skin = localStorage.getItem('tradingViewTheme') || 'black';


        if (!this.widgets) {
            this.widgets = new TradingView.widget({
                autosize: true,
                fullscreen: true,

                symbol: symbol,
                interval: resolution,
                container_id: 'tv_chart_container',
                datafeed: this.datafeeds,
                library_path: './charting_library/',
                enabled_features: [],
                timezone: timezone,
                custom_css_url: './css/tradingview_' + skin + '.css',
                locale: locale,
                debug: false,
                disabled_features: [
                    // "fullscreen",
                    // "autosize",
                    "header_symbol_search",
                    "use_localstorage_for_settings",
                    "header_fullscreen_button",
                    "header_saveload",
                    "header_screenshot",
                    "header_chart_type",
                    "header_compare",
                    "header_undo_redo",
                    "timeframes_toolbar",
                    "volume_force_overlay",
                    "header_resolutions",
                ],
                //设置初始化样式配置
                overrides: this.getOverrides(skin),
                studies_overrides: this.getStudiesOverrides(skin),

                //设置初始化加载条样式
                loading_screen: {
                    "backgroundColor": "#181328",
                    "foregroundColor": "#5d7d93"
                },
            })

            var thats = this.widgets;
            thats.onChartReady(function () {
                createStudy();
                createButton(buttons);
                thats.chart().setChartType(chartType);
                toggleStudy(chartType);
            })

            // 提交按钮
            var buttons = [
                { title: 'Time', resolution: '1', chartType: 3 }, // 1，2，3几种类型
                { title: '1min', resolution: '1', chartType: 1 },
                { title: '5min', resolution: '5', chartType: 1 },
                { title: '15min', resolution: '15', chartType: 1 },
                { title: '30min', resolution: '30', chartType: 1 },
                { title: '1hour', resolution: '60', chartType: 1 },
                { title: '1day', resolution: '1D', chartType: 1 },
                { title: '1week', resolution: '1W', chartType: 1 },
                { title: '1month', resolution: '1M', chartType: 1 },
            ];
            var studies = [];

            function createButton(buttons) {
                for (var i = 0; i < buttons.length; i++) {
                    (function (button) {
                        thats.createButton()
                            .attr('title', button.title).addClass("mydate")
                            .text(button.title)
                            .on('click', function (e) {
                                if (this.parentNode.className.search('active') > -1) {
                                    return false;
                                }
                                localStorage.setItem('tradingview.resolution', button.resolution);
                                localStorage.setItem('tradingview.chartType', button.chartType);
                                var $active = this.parentNode.parentNode.querySelector('.active');
                                $active.className = $active.className.replace(/(\sactive|active\s)/, '');
                                this.parentNode.className += ' active';
                                thats.chart().setResolution(button.resolution, function onReadyCallback() {
                                });
                                if (button.chartType != thats.chart().chartType()) {
                                    thats.chart().setChartType(button.chartType);
                                    toggleStudy(button.chartType);
                                }
                            }).parent().addClass('my-group' + (button.resolution == resolution && button.chartType == chartType ? ' active' : ''));
                    })(buttons[i]);
                }
            }

            function createStudy() {
                var id = thats.chart().createStudy('Moving Average', false, false, [15], null, { 'Plot.color': 'rgb(150, 95, 196)' });
                studies.push(id);
                id = thats.chart().createStudy('Moving Average', false, false, [30], null, { "plot.color": "rgb(118,32,99)" });
                studies.push(id);
                id = thats.chart().createStudy('Moving Average', false, false, [60], null, { 'Plot.color': 'rgb(116,149,187)' });
                studies.push(id);
            }

            function toggleStudy(chartType) {
                var state = chartType == 3 ? 0 : 1;
                for (var i = 0; i < studies.length; i++) {
                    thats.chart().getStudyById(studies[i]).setVisible(state);
                }
            }
        }
    };
    
    WsConfig.prototype.sendMessage = function (data) {
        var that = this;
        //console.log("这是要发送的数据：" + JSON.stringify(data))
        if (this.socket.checkOpen()) {
            this.socket.send(data)
        } else {
            this.socket.on('open', function () {
                that.socket.send(data)
            })
        }
    };

    WsConfig.prototype.unSubscribe = function (interval) {
        var thats = this;
        //停止订阅，删除过期缓存、缓存时间、缓存状态
        var ticker = this.symbol + "-" + interval;
        var tickertime = ticker + "load";
        var tickerstate = ticker + "state";
        var tickerCallback = ticker + "Callback";
        delete thats.cacheData[ticker];
        delete thats.cacheData[tickertime];
        delete thats.cacheData[tickerstate];
        delete thats.cacheData[tickerCallback];
        if (this.symbolId == 1) {
            if (interval <= 43200) {
                this.sendMessage({
                    unsub: "dynamic_kline_" + this.symbolId + "_" + interval,
                })
            } else if (interval == "1D") {
                this.sendMessage({
                    unsub: "dynamic_kline_" + this.symbolId + "_1440",
                })
            } else if (interval == "1W") {
                this.sendMessage({
                    unsub: "dynamic_kline_" + this.symbolId + "_10080",
                })
            } else if (interval == "1M") {
                this.sendMessage({
                    unsub: "dynamic_kline_" + this.symbolId + "_43200",
                })
            }
        } else if (this.symbolId == 2) {
            if (interval <= 43200) {
                this.sendMessage({
                    unsub: "futures_dynamic_kline_" + this.symbolId + "_" + interval,
                })
            } else if (interval == "1D") {
                this.sendMessage({
                    unsub: "futures_dynamic_kline_" + this.symbolId + "_1440",
                })
            } else if (interval == "1W") {
                this.sendMessage({
                    unsub: "futures_dynamic_kline_" + this.symbolId + "_10080",
                })
            } else if (interval == "1M") {
                this.sendMessage({
                    unsub: "futures_dynamic_kline_" + this.symbolId + "_43200",
                })
            }
        }

    };


    WsConfig.prototype.subscribe = function () {
        if (this.symbolType == 1) {
            if (this.interval <= 43200) {
                this.sendMessage({
                    sub: "dynamic_kline_" + this.symbolId + "_" + this.interval,
                })
            } else if (this.interval == "1D") {
                this.sendMessage({
                    sub: "dynamic_kline_" + this.symbolId + "_1440",
                })
            } else if (this.interval == "1W") {
                this.sendMessage({
                    sub: "dynamic_kline_" + this.symbolId + "_10080",
                })
            } else if (this.interval == "1M") {
                this.sendMessage({
                    sub: "dynamic_kline_" + this.symbolId + "_43200",
                })
            }
        } else if (this.symbolType == 2) {
            if (this.interval <= 43200) {
                this.sendMessage({
                    sub: "futures_dynamic_kline_" + this.symbolId + "_" + this.interval,
                })
            } else if (this.interval == "1D") {
                this.sendMessage({
                    sub: "futures_dynamic_kline_" + this.symbolId + "_1440",
                })
            } else if (this.interval == "1W") {
                this.sendMessage({
                    sub: "futures_dynamic_kline_" + this.symbolId + "_10080",
                })
            } else if (this.interval == "1M") {
                this.sendMessage({
                    sub: "futures_dynamic_kline_" + this.symbolId + "_43200",
                })
            }
        }
    };

    WsConfig.prototype.onMessage = function (data) {
        var thats = this;

        var isFuture = data.sub.startsWith('futures') ? 'futures_' : '';
        var interval = thats.interval;
        switch (interval.toLowerCase()) {
            case "1d":
                interval = "1440";
                break;
            case "1w":
                interval = "10080";
                break;
            case "1m":
                interval = "43200"
                break;
        }

        if (data.data && data.sub == `${isFuture}history_kline_${thats.symbolId}_${interval}`) {

            //websocket返回的值，数组代表时间段历史数据，不是增量
            var list = []
            var ticker = thats.symbol + "-" + thats.interval;
            var tickerstate = ticker + "state";
            var tickerCallback = ticker + "Callback";
            var onLoadedCallback = thats.cacheData[tickerCallback];

            //var that = thats;
            //遍历数组，构造缓存数据
            data.data.forEach(function (element) {
                list.push({
                    time: element.createTime * 1,
                    open: element.open,
                    high: element.high,
                    low: element.low,
                    close: element.close,
                    volume: element.qty,
                })
            }, thats);
            //如果没有缓存数据，则直接填充，发起订阅
            if (!thats.cacheData[ticker]) {
                thats.cacheData[ticker] = list;
                thats.subscribe()
            }
            //新数据即当前时间段需要的数据，直接喂给图表插件
            if (onLoadedCallback) {
                onLoadedCallback(list);
                delete thats.cacheData[tickerCallback];
            }
            //请求完成，设置状态为false
            thats.cacheData[tickerstate] = !1;
            //记录当前缓存时间，即数组最后一位的时间
            thats.lastTime = thats.cacheData[ticker][thats.cacheData[ticker].length - 1].time
        }

        if (data.data && data.sub == `${isFuture}dynamic_kline_${thats.symbolId}_${thats.interval}`) {

            // data带有type，即返回的是订阅数据，
            //缓存的key
            var ticker = thats.symbol + "-" + thats.interval;
            //构造增量更新数据
            var barsData = {
                time: data.data.createTime * 1,
                open: data.data.open,
                high: data.data.high,
                low: data.data.low,
                close: data.data.close,
                volume: data.data.qty
            };

            if (barsData.time >= thats.lastTime && thats.cacheData[ticker] && thats.cacheData[ticker].length) {
                if (thats.cacheData[ticker][thats.cacheData[ticker].length - 1].time == barsData.time) {
                    thats.cacheData[ticker][thats.cacheData[ticker].length - 1] = barsData;
                    thats.lastTime = barsData.time
                } else {
                    thats.cacheData[ticker].push(barsData);
                }
            }
            // 通知图表插件，可以开始增量更新的渲染了
            thats.datafeeds.barsUpdater.updateData()
        } else if (data.status) {
            var ticker = thats.symbol + "-" + thats.interval;
            var tickerCallback = ticker + "Callback";
            var onLoadedCallback = thats.cacheData[tickerCallback];
            if (onLoadedCallback) {
                onLoadedCallback([]);
                delete thats.cacheData[tickerCallback];
            }
        }
    };
    WsConfig.prototype.onClose = function () {
        var thats = this;
        console.log(' >> : 连接已断开... 正在重连')
        thats.socket.doOpen()
        thats.socket.on('open', function () {
            console.log(' >> : 已重连')
            thats.subscribe()
        });
    };

    WsConfig.prototype.initMessage = function (symbolInfo, resolution, rangeStartDate, rangeEndDate, onLoadedCallback) {
        var that = this;
        //保留当前回调
        var tickerCallback = this.symbol + "-" + resolution + "Callback";
        that.cacheData[tickerCallback] = onLoadedCallback;
        //获取需要请求的数据数目
        //商品名
        var symbol = that.symbol;
        //如果当前时间节点已经改变，停止上一个时间节点的订阅，修改时间节点值
        if (that.interval !== resolution) {
            that.unSubscribe(that.interval)
            that.interval = resolution;
        }
        //获取当前时间段的数据，在onMessage中执行回调onLoadedCallback
        if (this.symbolType == 1) {
            if (that.interval <= 43200) {
                that.socket.send({
                    request: "history_kline_" + this.symbolId + "_" + that.interval,
                    sub: "dynamic_kline_" + this.symbolId + "_" + that.interval,
                })
            } else if (that.interval == "1D") {
                that.socket.send({
                    request: "history_kline_" + this.symbolId + "_1440",
                    sub: "dynamic_kline_" + this.symbolId + "_1440",
                })
            } else if (that.interval == "1W") {
                that.socket.send({
                    request: "history_kline_" + this.symbolId + "_10080",
                    sub: "dynamic_kline_" + this.symbolId + "_10080",
                })
            } else if (that.interval == "1M") {
                that.socket.send({
                    request: "history_kline_" + this.symbolId + "_43200",
                    sub: "dynamic_kline_" + this.symbolId + "_43200",
                })
            }
        } else if (this.symbolType == 2) {
            if (that.interval <= 43200) {
                that.socket.send({
                    request: "futures_history_kline_" + this.symbolId + "_" + that.interval,
                    sub: "futures_dynamic_kline_" + this.symbolId + "_" + that.interval,
                })
            } else if (that.interval == "1D") {
                that.socket.send({
                    request: "futures_history_kline_" + this.symbolId + "_1440",
                    sub: "futures_dynamic_kline_" + this.symbolId + "_1440",
                })
            } else if (that.interval == "1W") {
                that.socket.send({
                    request: "futures_history_kline_" + this.symbolId + "_10080",
                    sub: "futures_dynamic_kline_" + this.symbolId + "_10080",
                })
            } else if (that.interval == "1M") {
                that.socket.send({
                    request: "futures_history_kline_" + this.symbolId + "_43200",
                    sub: "futures_dynamic_kline_" + this.symbolId + "_43200",
                })
            }
        }

    };

    WsConfig.prototype.getBars = function (symbolInfo, resolution, rangeStartDate, rangeEndDate, onLoadedCallback) {
        //console.log(' >> :', rangeStartDate, rangeEndDate)

        var ticker = this.symbol + "-" + resolution;
        var tickerload = ticker + "load";
        var tickerstate = ticker + "state";

        if (!this.cacheData[ticker] && !this.cacheData[tickerstate]) {
            //如果缓存没有数据，而且未发出请求，记录当前节点开始时间
            this.cacheData[tickerload] = rangeStartDate;
            //发起请求，从websocket获取当前时间段的数据
            this.initMessage(symbolInfo, resolution, rangeStartDate, rangeEndDate, onLoadedCallback);
            //设置状态为true
            this.cacheData[tickerstate] = !0;
            return false;
        }

        if (this.cacheData[tickerstate]) {
            //正在从websocket获取数据，禁止一切操作
            return false;
        }
        ticker = this.symbol + "-" + this.interval;
        if (this.cacheData[ticker] && this.cacheData[ticker].length) {
            this.isLoading = false;
            var newBars = []
            this.cacheData[ticker].forEach(function (item) {
                if (item.time >= rangeStartDate * 1000 && item.time <= rangeEndDate * 1000) {
                    newBars.push(item)
                }
            });
            onLoadedCallback(newBars)
        } else {
            var self = this
            this.getBarTimer = setTimeout(function () {
                self.getBars(symbolInfo, resolution, rangeStartDate, rangeEndDate, onLoadedCallback)
            }, 100)
        }
    };

    WsConfig.prototype.getOverrides = function (theme) {
        var themes = {
            "white": {
                up: "#03c087",
                down: "#ff5959",
                bg: "#ffffff",
                grid: "#f7f8fa",
                cross: "#23283D",
                border: "#9194a4",
                text: "#9194a4",
                areatop: "rgba(71, 78, 112, 0.1)",
                areadown: "rgba(71, 78, 112, 0.02)",
                line: "#737375"
            },
            "black": {
                up: "#25bc67",
                down: "#ff5959",
                bg: "#181328",
                grid: "#1f2943",
                cross: "#9194A3",
                border: "#4e5b85",
                text: "#61688A",
                areatop: "rgba(122, 152, 247, .1)",
                areadown: "rgba(122, 152, 247, .02)",
                line: "#737375"
            },
            "mobile": {
                up: "#03C087",
                down: "#E76D42",
                bg: "#ffffff",
                grid: "#f7f8fa",
                cross: "#23283D",
                border: "#C5CFD5",
                text: "#8C9FAD",
                areatop: "rgba(71, 78, 112, 0.1)",
                areadown: "rgba(71, 78, 112, 0.02)",
                showLegend: !0
            }
        };
        var t = themes[theme];
        return {
            "volumePaneSize": "medium",
            "scalesProperties.lineColor": t.text,
            "scalesProperties.textColor": "#ffffff",
            "paneProperties.background": t.bg,
            "paneProperties.vertGridProperties.color": t.grid,
            "paneProperties.horzGridProperties.color": t.grid,
            "paneProperties.crossHairProperties.color": t.cross,
            "paneProperties.legendProperties.showLegend": !!t.showLegend,
            "paneProperties.legendProperties.showStudyArguments": !0,
            "paneProperties.legendProperties.showStudyTitles": !0,
            "paneProperties.legendProperties.showStudyValues": !0,
            "paneProperties.legendProperties.showSeriesTitle": !0,
            "paneProperties.legendProperties.showSeriesOHLC": !0,
            "mainSeriesProperties.candleStyle.upColor": t.up,
            "mainSeriesProperties.candleStyle.downColor": t.down,
            "mainSeriesProperties.candleStyle.drawWick": !0,
            "mainSeriesProperties.candleStyle.drawBorder": !0,
            "mainSeriesProperties.candleStyle.borderColor": t.border,
            "mainSeriesProperties.candleStyle.borderUpColor": t.up,
            "mainSeriesProperties.candleStyle.borderDownColor": t.down,
            "mainSeriesProperties.candleStyle.wickUpColor": t.up,
            "mainSeriesProperties.candleStyle.wickDownColor": t.down,
            "mainSeriesProperties.candleStyle.barColorsOnPrevClose": !1,
            "mainSeriesProperties.hollowCandleStyle.upColor": t.up,
            "mainSeriesProperties.hollowCandleStyle.downColor": t.down,
            "mainSeriesProperties.hollowCandleStyle.drawWick": !0,
            "mainSeriesProperties.hollowCandleStyle.drawBorder": !0,
            "mainSeriesProperties.hollowCandleStyle.borderColor": t.border,
            "mainSeriesProperties.hollowCandleStyle.borderUpColor": t.up,
            "mainSeriesProperties.hollowCandleStyle.borderDownColor": t.down,
            "mainSeriesProperties.hollowCandleStyle.wickColor": t.line,
            "mainSeriesProperties.haStyle.upColor": t.up,
            "mainSeriesProperties.haStyle.downColor": t.down,
            "mainSeriesProperties.haStyle.drawWick": !0,
            "mainSeriesProperties.haStyle.drawBorder": !0,
            "mainSeriesProperties.haStyle.borderColor": t.border,
            "mainSeriesProperties.haStyle.borderUpColor": t.up,
            "mainSeriesProperties.haStyle.borderDownColor": t.down,
            "mainSeriesProperties.haStyle.wickColor": t.border,
            "mainSeriesProperties.haStyle.barColorsOnPrevClose": !1,
            "mainSeriesProperties.barStyle.upColor": t.up,
            "mainSeriesProperties.barStyle.downColor": t.down,
            "mainSeriesProperties.barStyle.barColorsOnPrevClose": !1,
            "mainSeriesProperties.barStyle.dontDrawOpen": !1,
            "mainSeriesProperties.lineStyle.color": t.border,
            "mainSeriesProperties.lineStyle.linewidth": 1,
            "mainSeriesProperties.lineStyle.priceSource": "close",
            "mainSeriesProperties.areaStyle.color1": t.areatop,
            "mainSeriesProperties.areaStyle.color2": t.areadown,
            "mainSeriesProperties.areaStyle.linecolor": t.border,
            "mainSeriesProperties.areaStyle.linewidth": 1,
            "mainSeriesProperties.areaStyle.priceSource": "close"
        }
    };

    WsConfig.prototype.getStudiesOverrides = function (theme) {
        var themes = {
            "white": {
                c0: "#eb4d5c",
                c1: "#53b987",
                t: 70,
                v: !1
            },
            "black": {
                c0: "#D82B2B",
                c1: "#25BC67",
                t: 70,
                v: !1
            }
        };
        var t = themes[theme];
        return {
            "volume.volume.color.0": t.c0,
            "volume.volume.color.1": t.c1,
            "volume.volume.transparency": t.t,
            "volume.options.showStudyArguments": t.v
        }
    };

    WsConfig.prototype.resetTheme = function (skin) {
        this.widgets.addCustomCSSFile('./tradingview_' + skin + '.css');
        this.widgets.applyOverrides(this.getOverrides(skin));
        this.widgets.applyStudiesOverrides(this.getStudiesOverrides(skin));
    };

    WsConfig.prototype.formatt = function (time) {
        if (isNaN(time)) {
            return time;
        }
        var date = new Date(time);
        var Y = date.getFullYear();
        var m = this._formatt(date.getMonth());
        var d = this._formatt(date.getDate());
        var H = this._formatt(date.getHours());
        var i = this._formatt(date.getMinutes());
        var s = this._formatt(date.getSeconds());
        return Y + '-' + m + '-' + d + ' ' + H + ':' + i + ':' + s;
    };
    WsConfig.prototype._formatt = function (num) {
        return num >= 10 ? num : '0' + num;
    };
    return WsConfig;
})();
