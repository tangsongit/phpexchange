<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection deep
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection payword
     * @property Grid\Column|Collection invite_code
     * @property Grid\Column|Collection account
     * @property Grid\Column|Collection account_type
     * @property Grid\Column|Collection pid
     * @property Grid\Column|Collection country_code
     * @property Grid\Column|Collection user_grade
     * @property Grid\Column|Collection user_identity
     * @property Grid\Column|Collection user_auth_level
     * @property Grid\Column|Collection login_code
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection reg_ip
     * @property Grid\Column|Collection last_login_time
     * @property Grid\Column|Collection last_login_ip
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection trade_status
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection coin_id
     * @property Grid\Column|Collection coin_name
     * @property Grid\Column|Collection collection_wallet
     * @property Grid\Column|Collection datetime
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection agent_level
     * @property Grid\Column|Collection agent_name
     * @property Grid\Column|Collection draw_out_direction
     * @property Grid\Column|Collection into_direction
     * @property Grid\Column|Collection usable_balance
     * @property Grid\Column|Collection freeze_balance
     * @property Grid\Column|Collection log_type
     * @property Grid\Column|Collection rich_type
     * @property Grid\Column|Collection log_note
     * @property Grid\Column|Collection before_balance
     * @property Grid\Column|Collection after_balance
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection bet_amount
     * @property Grid\Column|Collection bet_coin_name
     * @property Grid\Column|Collection odds
     * @property Grid\Column|Collection range
     * @property Grid\Column|Collection fee
     * @property Grid\Column|Collection delivery_amount
     * @property Grid\Column|Collection delivery_time
     * @property Grid\Column|Collection order_no
     * @property Grid\Column|Collection up_down
     * @property Grid\Column|Collection symbol
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection entrust_price
     * @property Grid\Column|Collection trigger_price
     * @property Grid\Column|Collection quote_coin_id
     * @property Grid\Column|Collection base_coin_id
     * @property Grid\Column|Collection traded_amount
     * @property Grid\Column|Collection money
     * @property Grid\Column|Collection traded_money
     * @property Grid\Column|Collection entrust_type
     * @property Grid\Column|Collection cancel_time
     * @property Grid\Column|Collection hang_status
     * @property Grid\Column|Collection buy_order_no
     * @property Grid\Column|Collection sell_order_no
     * @property Grid\Column|Collection unit_price
     * @property Grid\Column|Collection trade_amount
     * @property Grid\Column|Collection trade_money
     * @property Grid\Column|Collection trade_buy_fee
     * @property Grid\Column|Collection trade_sell_fee
     * @property Grid\Column|Collection buy_id
     * @property Grid\Column|Collection sell_id
     * @property Grid\Column|Collection buy_user_id
     * @property Grid\Column|Collection sell_user_id
     * @property Grid\Column|Collection trade_fee
     * @property Grid\Column|Collection payment_amount
     * @property Grid\Column|Collection payment_currency
     * @property Grid\Column|Collection subscription_time
     * @property Grid\Column|Collection subscription_currency_name
     * @property Grid\Column|Collection subscription_currency_amount
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection user_password_hash
     * @property Grid\Column|Collection new_password
     * @property Grid\Column|Collection operation_time
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection module
     * @property Grid\Column|Collection key
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection tips
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection locale
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection realname
     * @property Grid\Column|Collection contents
     * @property Grid\Column|Collection imgs
     * @property Grid\Column|Collection is_process
     * @property Grid\Column|Collection process_note
     * @property Grid\Column|Collection process_time
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection client_type
     * @property Grid\Column|Collection is_must
     * @property Grid\Column|Collection update_log
     * @property Grid\Column|Collection url
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection article_id
     * @property Grid\Column|Collection body
     * @property Grid\Column|Collection excerpt
     * @property Grid\Column|Collection admin_user_id
     * @property Grid\Column|Collection view_count
     * @property Grid\Column|Collection cover
     * @property Grid\Column|Collection is_recommend
     * @property Grid\Column|Collection location_type
     * @property Grid\Column|Collection tourl
     * @property Grid\Column|Collection tourl_type
     * @property Grid\Column|Collection b_id
     * @property Grid\Column|Collection imgurl
     * @property Grid\Column|Collection nation_name
     * @property Grid\Column|Collection hand_time
     * @property Grid\Column|Collection bonusable_id
     * @property Grid\Column|Collection bonusable_type
     * @property Grid\Column|Collection center_wallet_id
     * @property Grid\Column|Collection center_wallet_name
     * @property Grid\Column|Collection center_wallet_account
     * @property Grid\Column|Collection center_wallet_address
     * @property Grid\Column|Collection center_wallet_password
     * @property Grid\Column|Collection center_wallet_balance
     * @property Grid\Column|Collection min_amount
     * @property Grid\Column|Collection open
     * @property Grid\Column|Collection high
     * @property Grid\Column|Collection low
     * @property Grid\Column|Collection close
     * @property Grid\Column|Collection max_amount
     * @property Grid\Column|Collection qty_decimals
     * @property Grid\Column|Collection price_decimals
     * @property Grid\Column|Collection full_name
     * @property Grid\Column|Collection withdrawal_fee
     * @property Grid\Column|Collection withdrawal_min
     * @property Grid\Column|Collection withdrawal_max
     * @property Grid\Column|Collection coin_withdraw_message
     * @property Grid\Column|Collection coin_recharge_message
     * @property Grid\Column|Collection coin_transfer_message
     * @property Grid\Column|Collection coin_content
     * @property Grid\Column|Collection coin_icon
     * @property Grid\Column|Collection appKey
     * @property Grid\Column|Collection appSecret
     * @property Grid\Column|Collection official_website_link
     * @property Grid\Column|Collection white_paper_link
     * @property Grid\Column|Collection block_query_link
     * @property Grid\Column|Collection publish_time
     * @property Grid\Column|Collection total_issuance
     * @property Grid\Column|Collection total_circulation
     * @property Grid\Column|Collection crowdfunding_price
     * @property Grid\Column|Collection is_withdraw
     * @property Grid\Column|Collection is_recharge
     * @property Grid\Column|Collection can_recharge
     * @property Grid\Column|Collection pair_id
     * @property Grid\Column|Collection pair_name
     * @property Grid\Column|Collection margin_name
     * @property Grid\Column|Collection used_balance
     * @property Grid\Column|Collection contract_id
     * @property Grid\Column|Collection bid_plus_unit
     * @property Grid\Column|Collection bid_plus_count
     * @property Grid\Column|Collection bid_minus_unit
     * @property Grid\Column|Collection bid_minus_count
     * @property Grid\Column|Collection ask_plus_unit
     * @property Grid\Column|Collection ask_plus_count
     * @property Grid\Column|Collection ask_minus_unit
     * @property Grid\Column|Collection ask_minus_count
     * @property Grid\Column|Collection order_type
     * @property Grid\Column|Collection side
     * @property Grid\Column|Collection contract_coin_id
     * @property Grid\Column|Collection margin_coin_id
     * @property Grid\Column|Collection unit_amount
     * @property Grid\Column|Collection avg_price
     * @property Grid\Column|Collection profit
     * @property Grid\Column|Collection settle_profit
     * @property Grid\Column|Collection is_wear
     * @property Grid\Column|Collection lever_rate
     * @property Grid\Column|Collection margin
     * @property Grid\Column|Collection ts
     * @property Grid\Column|Collection system
     * @property Grid\Column|Collection contract_coin_name
     * @property Grid\Column|Collection maker_fee_rate
     * @property Grid\Column|Collection taker_fee_rate
     * @property Grid\Column|Collection lever_rage
     * @property Grid\Column|Collection default_lever
     * @property Grid\Column|Collection min_qty
     * @property Grid\Column|Collection max_qty
     * @property Grid\Column|Collection total_max_qty
     * @property Grid\Column|Collection buy_spread
     * @property Grid\Column|Collection sell_spread
     * @property Grid\Column|Collection settle_spread
     * @property Grid\Column|Collection margin_mode
     * @property Grid\Column|Collection liquidation_price
     * @property Grid\Column|Collection hold_position
     * @property Grid\Column|Collection avail_position
     * @property Grid\Column|Collection freeze_position
     * @property Grid\Column|Collection position_margin
     * @property Grid\Column|Collection settlement_price
     * @property Grid\Column|Collection maintain_margin_rate
     * @property Grid\Column|Collection settled_pnl
     * @property Grid\Column|Collection realized_pnl
     * @property Grid\Column|Collection unrealized_pnl
     * @property Grid\Column|Collection bg_img
     * @property Grid\Column|Collection text_img
     * @property Grid\Column|Collection peri_img
     * @property Grid\Column|Collection position_side
     * @property Grid\Column|Collection current_price
     * @property Grid\Column|Collection sl_price
     * @property Grid\Column|Collection sl_trigger_price
     * @property Grid\Column|Collection sl_trigger_type
     * @property Grid\Column|Collection tp_price
     * @property Grid\Column|Collection tp_trigger_price
     * @property Grid\Column|Collection tp_trigger_type
     * @property Grid\Column|Collection open_position_price
     * @property Grid\Column|Collection close_position_price
     * @property Grid\Column|Collection loss
     * @property Grid\Column|Collection code
     * @property Grid\Column|Collection en_name
     * @property Grid\Column|Collection Symbol
     * @property Grid\Column|Collection Date
     * @property Grid\Column|Collection Name
     * @property Grid\Column|Collection Open
     * @property Grid\Column|Collection High
     * @property Grid\Column|Collection Low
     * @property Grid\Column|Collection Close
     * @property Grid\Column|Collection LastClose
     * @property Grid\Column|Collection Price2
     * @property Grid\Column|Collection Price3
     * @property Grid\Column|Collection Open_Int
     * @property Grid\Column|Collection Volume
     * @property Grid\Column|Collection Amount
     * @property Grid\Column|Collection is_1min
     * @property Grid\Column|Collection is_5min
     * @property Grid\Column|Collection is_15min
     * @property Grid\Column|Collection is_30min
     * @property Grid\Column|Collection is_1h
     * @property Grid\Column|Collection is_2h
     * @property Grid\Column|Collection is_4h
     * @property Grid\Column|Collection is_6h
     * @property Grid\Column|Collection is_12h
     * @property Grid\Column|Collection is_day
     * @property Grid\Column|Collection is_week
     * @property Grid\Column|Collection is_month
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection quote_coin_name
     * @property Grid\Column|Collection base_coin_name
     * @property Grid\Column|Collection min_total
     * @property Grid\Column|Collection trigger_price_buy_rate
     * @property Grid\Column|Collection trigger_price_sell_rate
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection is_market
     * @property Grid\Column|Collection up_or_down
     * @property Grid\Column|Collection start_time
     * @property Grid\Column|Collection end_time
     * @property Grid\Column|Collection order_amount
     * @property Grid\Column|Collection bid_place_threshold
     * @property Grid\Column|Collection ask_place_threshold
     * @property Grid\Column|Collection attempts
     * @property Grid\Column|Collection reserved_at
     * @property Grid\Column|Collection available_at
     * @property Grid\Column|Collection img
     * @property Grid\Column|Collection link_type
     * @property Grid\Column|Collection link_data
     * @property Grid\Column|Collection desc
     * @property Grid\Column|Collection n_id
     * @property Grid\Column|Collection notifiable_type
     * @property Grid\Column|Collection notifiable_id
     * @property Grid\Column|Collection data
     * @property Grid\Column|Collection read_at
     * @property Grid\Column|Collection is_bet
     * @property Grid\Column|Collection scene_id
     * @property Grid\Column|Collection scene_sn
     * @property Grid\Column|Collection time_id
     * @property Grid\Column|Collection seconds
     * @property Grid\Column|Collection pair_time_name
     * @property Grid\Column|Collection up_odds
     * @property Grid\Column|Collection down_odds
     * @property Grid\Column|Collection draw_odds
     * @property Grid\Column|Collection begin_time
     * @property Grid\Column|Collection begin_price
     * @property Grid\Column|Collection end_price
     * @property Grid\Column|Collection delivery_up_down
     * @property Grid\Column|Collection delivery_range
     * @property Grid\Column|Collection time_name
     * @property Grid\Column|Collection bet_coin_id
     * @property Grid\Column|Collection odds_uuid
     * @property Grid\Column|Collection fee_rate
     * @property Grid\Column|Collection odds_up_range
     * @property Grid\Column|Collection odds_down_range
     * @property Grid\Column|Collection odds_draw_range
     * @property Grid\Column|Collection describe
     * @property Grid\Column|Collection image
     * @property Grid\Column|Collection limit_amount
     * @property Grid\Column|Collection max_register_time
     * @property Grid\Column|Collection max_register_num
     * @property Grid\Column|Collection order_sn
     * @property Grid\Column|Collection min_num
     * @property Grid\Column|Collection max_num
     * @property Grid\Column|Collection note
     * @property Grid\Column|Collection pay_type
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection cur_amount
     * @property Grid\Column|Collection lock_amount
     * @property Grid\Column|Collection order_count
     * @property Grid\Column|Collection deal_count
     * @property Grid\Column|Collection deal_rate
     * @property Grid\Column|Collection overed_at
     * @property Grid\Column|Collection trans_type
     * @property Grid\Column|Collection other_uid
     * @property Grid\Column|Collection entrust_id
     * @property Grid\Column|Collection order_time
     * @property Grid\Column|Collection pay_time
     * @property Grid\Column|Collection deal_time
     * @property Grid\Column|Collection appeal_status
     * @property Grid\Column|Collection appeal_time
     * @property Grid\Column|Collection paid_img
     * @property Grid\Column|Collection aid
     * @property Grid\Column|Collection subscribe_performance
     * @property Grid\Column|Collection contract_performance
     * @property Grid\Column|Collection option_performance
     * @property Grid\Column|Collection subscribe_rebate_rate
     * @property Grid\Column|Collection contract_rebate_rate
     * @property Grid\Column|Collection option_rebate_rate
     * @property Grid\Column|Collection subscribe_rebate
     * @property Grid\Column|Collection contract_rebate
     * @property Grid\Column|Collection option_rebate
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection uid
     * @property Grid\Column|Collection num
     * @property Grid\Column|Collection params
     * @property Grid\Column|Collection lang
     * @property Grid\Column|Collection json_content
     * @property Grid\Column|Collection file
     * @property Grid\Column|Collection rebate_rate
     * @property Grid\Column|Collection rebate_rate_exchange
     * @property Grid\Column|Collection rebate_rate_subscribe
     * @property Grid\Column|Collection rebate_rate_contract
     * @property Grid\Column|Collection rebate_rate_option
     * @property Grid\Column|Collection open_time
     * @property Grid\Column|Collection country_id
     * @property Grid\Column|Collection id_card
     * @property Grid\Column|Collection birthday
     * @property Grid\Column|Collection city
     * @property Grid\Column|Collection postal_code
     * @property Grid\Column|Collection extra
     * @property Grid\Column|Collection front_img
     * @property Grid\Column|Collection back_img
     * @property Grid\Column|Collection hand_img
     * @property Grid\Column|Collection check_time
     * @property Grid\Column|Collection primary_status
     * @property Grid\Column|Collection grade_id
     * @property Grid\Column|Collection grade_name
     * @property Grid\Column|Collection grade_name_en
     * @property Grid\Column|Collection grade_name_tw
     * @property Grid\Column|Collection grade_img
     * @property Grid\Column|Collection ug_self_vol
     * @property Grid\Column|Collection ug_recommend_grade
     * @property Grid\Column|Collection ug_recommend_num
     * @property Grid\Column|Collection ug_total_vol
     * @property Grid\Column|Collection ug_direct_vol
     * @property Grid\Column|Collection ug_direct_vol_num
     * @property Grid\Column|Collection ug_direct_recharge
     * @property Grid\Column|Collection ug_direct_recharge_num
     * @property Grid\Column|Collection bonus
     * @property Grid\Column|Collection login_time
     * @property Grid\Column|Collection login_ip
     * @property Grid\Column|Collection login_site
     * @property Grid\Column|Collection login_type
     * @property Grid\Column|Collection bank_name
     * @property Grid\Column|Collection real_name
     * @property Grid\Column|Collection card_no
     * @property Grid\Column|Collection open_bank
     * @property Grid\Column|Collection code_img
     * @property Grid\Column|Collection issue_price
     * @property Grid\Column|Collection subscribe_currency
     * @property Grid\Column|Collection expected_time_online
     * @property Grid\Column|Collection start_subscription_time
     * @property Grid\Column|Collection end_subscription_time
     * @property Grid\Column|Collection announce_time
     * @property Grid\Column|Collection project_details
     * @property Grid\Column|Collection en_project_details
     * @property Grid\Column|Collection maximum_purchase
     * @property Grid\Column|Collection minimum_purchase
     * @property Grid\Column|Collection en_direction_out
     * @property Grid\Column|Collection en_direction_in
     * @property Grid\Column|Collection tw_direction_out
     * @property Grid\Column|Collection tw_direction_in
     * @property Grid\Column|Collection user_old_grade
     * @property Grid\Column|Collection user_new_grade
     * @property Grid\Column|Collection wallet_id
     * @property Grid\Column|Collection omni_wallet_address
     * @property Grid\Column|Collection trx_wallet_address
     * @property Grid\Column|Collection wallet_address
     * @property Grid\Column|Collection raw_data
     * @property Grid\Column|Collection s_user_id
     * @property Grid\Column|Collection sub_account
     * @property Grid\Column|Collection logable_id
     * @property Grid\Column|Collection logable_type
     * @property Grid\Column|Collection txid
     * @property Grid\Column|Collection address_type
     * @property Grid\Column|Collection total_amount
     * @property Grid\Column|Collection address_note
     * @property Grid\Column|Collection hash
     * @property Grid\Column|Collection referrer
     * @property Grid\Column|Collection phone_status
     * @property Grid\Column|Collection email_status
     * @property Grid\Column|Collection google_token
     * @property Grid\Column|Collection google_status
     * @property Grid\Column|Collection second_verify
     * @property Grid\Column|Collection purchase_code
     * @property Grid\Column|Collection is_agency
     * @property Grid\Column|Collection is_system
     * @property Grid\Column|Collection contract_deal
     * @property Grid\Column|Collection trade_verify
     * @property Grid\Column|Collection contract_anomaly
     * @property Grid\Column|Collection from
     * @property Grid\Column|Collection to
     * @property Grid\Column|Collection ispb
     * @property Grid\Column|Collection code_number
     * @property Grid\Column|Collection nome_extenso
     * @property Grid\Column|Collection createtime
     *
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection deep(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection payword(string $label = null)
     * @method Grid\Column|Collection invite_code(string $label = null)
     * @method Grid\Column|Collection account(string $label = null)
     * @method Grid\Column|Collection account_type(string $label = null)
     * @method Grid\Column|Collection pid(string $label = null)
     * @method Grid\Column|Collection country_code(string $label = null)
     * @method Grid\Column|Collection user_grade(string $label = null)
     * @method Grid\Column|Collection user_identity(string $label = null)
     * @method Grid\Column|Collection user_auth_level(string $label = null)
     * @method Grid\Column|Collection login_code(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection reg_ip(string $label = null)
     * @method Grid\Column|Collection last_login_time(string $label = null)
     * @method Grid\Column|Collection last_login_ip(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection trade_status(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection coin_id(string $label = null)
     * @method Grid\Column|Collection coin_name(string $label = null)
     * @method Grid\Column|Collection collection_wallet(string $label = null)
     * @method Grid\Column|Collection datetime(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection agent_level(string $label = null)
     * @method Grid\Column|Collection agent_name(string $label = null)
     * @method Grid\Column|Collection draw_out_direction(string $label = null)
     * @method Grid\Column|Collection into_direction(string $label = null)
     * @method Grid\Column|Collection usable_balance(string $label = null)
     * @method Grid\Column|Collection freeze_balance(string $label = null)
     * @method Grid\Column|Collection log_type(string $label = null)
     * @method Grid\Column|Collection rich_type(string $label = null)
     * @method Grid\Column|Collection log_note(string $label = null)
     * @method Grid\Column|Collection before_balance(string $label = null)
     * @method Grid\Column|Collection after_balance(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection bet_amount(string $label = null)
     * @method Grid\Column|Collection bet_coin_name(string $label = null)
     * @method Grid\Column|Collection odds(string $label = null)
     * @method Grid\Column|Collection range(string $label = null)
     * @method Grid\Column|Collection fee(string $label = null)
     * @method Grid\Column|Collection delivery_amount(string $label = null)
     * @method Grid\Column|Collection delivery_time(string $label = null)
     * @method Grid\Column|Collection order_no(string $label = null)
     * @method Grid\Column|Collection up_down(string $label = null)
     * @method Grid\Column|Collection symbol(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection entrust_price(string $label = null)
     * @method Grid\Column|Collection trigger_price(string $label = null)
     * @method Grid\Column|Collection quote_coin_id(string $label = null)
     * @method Grid\Column|Collection base_coin_id(string $label = null)
     * @method Grid\Column|Collection traded_amount(string $label = null)
     * @method Grid\Column|Collection money(string $label = null)
     * @method Grid\Column|Collection traded_money(string $label = null)
     * @method Grid\Column|Collection entrust_type(string $label = null)
     * @method Grid\Column|Collection cancel_time(string $label = null)
     * @method Grid\Column|Collection hang_status(string $label = null)
     * @method Grid\Column|Collection buy_order_no(string $label = null)
     * @method Grid\Column|Collection sell_order_no(string $label = null)
     * @method Grid\Column|Collection unit_price(string $label = null)
     * @method Grid\Column|Collection trade_amount(string $label = null)
     * @method Grid\Column|Collection trade_money(string $label = null)
     * @method Grid\Column|Collection trade_buy_fee(string $label = null)
     * @method Grid\Column|Collection trade_sell_fee(string $label = null)
     * @method Grid\Column|Collection buy_id(string $label = null)
     * @method Grid\Column|Collection sell_id(string $label = null)
     * @method Grid\Column|Collection buy_user_id(string $label = null)
     * @method Grid\Column|Collection sell_user_id(string $label = null)
     * @method Grid\Column|Collection trade_fee(string $label = null)
     * @method Grid\Column|Collection payment_amount(string $label = null)
     * @method Grid\Column|Collection payment_currency(string $label = null)
     * @method Grid\Column|Collection subscription_time(string $label = null)
     * @method Grid\Column|Collection subscription_currency_name(string $label = null)
     * @method Grid\Column|Collection subscription_currency_amount(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection user_password_hash(string $label = null)
     * @method Grid\Column|Collection new_password(string $label = null)
     * @method Grid\Column|Collection operation_time(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection module(string $label = null)
     * @method Grid\Column|Collection key(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection tips(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection locale(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection realname(string $label = null)
     * @method Grid\Column|Collection contents(string $label = null)
     * @method Grid\Column|Collection imgs(string $label = null)
     * @method Grid\Column|Collection is_process(string $label = null)
     * @method Grid\Column|Collection process_note(string $label = null)
     * @method Grid\Column|Collection process_time(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection client_type(string $label = null)
     * @method Grid\Column|Collection is_must(string $label = null)
     * @method Grid\Column|Collection update_log(string $label = null)
     * @method Grid\Column|Collection url(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection article_id(string $label = null)
     * @method Grid\Column|Collection body(string $label = null)
     * @method Grid\Column|Collection excerpt(string $label = null)
     * @method Grid\Column|Collection admin_user_id(string $label = null)
     * @method Grid\Column|Collection view_count(string $label = null)
     * @method Grid\Column|Collection cover(string $label = null)
     * @method Grid\Column|Collection is_recommend(string $label = null)
     * @method Grid\Column|Collection location_type(string $label = null)
     * @method Grid\Column|Collection tourl(string $label = null)
     * @method Grid\Column|Collection tourl_type(string $label = null)
     * @method Grid\Column|Collection b_id(string $label = null)
     * @method Grid\Column|Collection imgurl(string $label = null)
     * @method Grid\Column|Collection nation_name(string $label = null)
     * @method Grid\Column|Collection hand_time(string $label = null)
     * @method Grid\Column|Collection bonusable_id(string $label = null)
     * @method Grid\Column|Collection bonusable_type(string $label = null)
     * @method Grid\Column|Collection center_wallet_id(string $label = null)
     * @method Grid\Column|Collection center_wallet_name(string $label = null)
     * @method Grid\Column|Collection center_wallet_account(string $label = null)
     * @method Grid\Column|Collection center_wallet_address(string $label = null)
     * @method Grid\Column|Collection center_wallet_password(string $label = null)
     * @method Grid\Column|Collection center_wallet_balance(string $label = null)
     * @method Grid\Column|Collection min_amount(string $label = null)
     * @method Grid\Column|Collection open(string $label = null)
     * @method Grid\Column|Collection high(string $label = null)
     * @method Grid\Column|Collection low(string $label = null)
     * @method Grid\Column|Collection close(string $label = null)
     * @method Grid\Column|Collection max_amount(string $label = null)
     * @method Grid\Column|Collection qty_decimals(string $label = null)
     * @method Grid\Column|Collection price_decimals(string $label = null)
     * @method Grid\Column|Collection full_name(string $label = null)
     * @method Grid\Column|Collection withdrawal_fee(string $label = null)
     * @method Grid\Column|Collection withdrawal_min(string $label = null)
     * @method Grid\Column|Collection withdrawal_max(string $label = null)
     * @method Grid\Column|Collection coin_withdraw_message(string $label = null)
     * @method Grid\Column|Collection coin_recharge_message(string $label = null)
     * @method Grid\Column|Collection coin_transfer_message(string $label = null)
     * @method Grid\Column|Collection coin_content(string $label = null)
     * @method Grid\Column|Collection coin_icon(string $label = null)
     * @method Grid\Column|Collection appKey(string $label = null)
     * @method Grid\Column|Collection appSecret(string $label = null)
     * @method Grid\Column|Collection official_website_link(string $label = null)
     * @method Grid\Column|Collection white_paper_link(string $label = null)
     * @method Grid\Column|Collection block_query_link(string $label = null)
     * @method Grid\Column|Collection publish_time(string $label = null)
     * @method Grid\Column|Collection total_issuance(string $label = null)
     * @method Grid\Column|Collection total_circulation(string $label = null)
     * @method Grid\Column|Collection crowdfunding_price(string $label = null)
     * @method Grid\Column|Collection is_withdraw(string $label = null)
     * @method Grid\Column|Collection is_recharge(string $label = null)
     * @method Grid\Column|Collection can_recharge(string $label = null)
     * @method Grid\Column|Collection pair_id(string $label = null)
     * @method Grid\Column|Collection pair_name(string $label = null)
     * @method Grid\Column|Collection margin_name(string $label = null)
     * @method Grid\Column|Collection used_balance(string $label = null)
     * @method Grid\Column|Collection contract_id(string $label = null)
     * @method Grid\Column|Collection bid_plus_unit(string $label = null)
     * @method Grid\Column|Collection bid_plus_count(string $label = null)
     * @method Grid\Column|Collection bid_minus_unit(string $label = null)
     * @method Grid\Column|Collection bid_minus_count(string $label = null)
     * @method Grid\Column|Collection ask_plus_unit(string $label = null)
     * @method Grid\Column|Collection ask_plus_count(string $label = null)
     * @method Grid\Column|Collection ask_minus_unit(string $label = null)
     * @method Grid\Column|Collection ask_minus_count(string $label = null)
     * @method Grid\Column|Collection order_type(string $label = null)
     * @method Grid\Column|Collection side(string $label = null)
     * @method Grid\Column|Collection contract_coin_id(string $label = null)
     * @method Grid\Column|Collection margin_coin_id(string $label = null)
     * @method Grid\Column|Collection unit_amount(string $label = null)
     * @method Grid\Column|Collection avg_price(string $label = null)
     * @method Grid\Column|Collection profit(string $label = null)
     * @method Grid\Column|Collection settle_profit(string $label = null)
     * @method Grid\Column|Collection is_wear(string $label = null)
     * @method Grid\Column|Collection lever_rate(string $label = null)
     * @method Grid\Column|Collection margin(string $label = null)
     * @method Grid\Column|Collection ts(string $label = null)
     * @method Grid\Column|Collection system(string $label = null)
     * @method Grid\Column|Collection contract_coin_name(string $label = null)
     * @method Grid\Column|Collection maker_fee_rate(string $label = null)
     * @method Grid\Column|Collection taker_fee_rate(string $label = null)
     * @method Grid\Column|Collection lever_rage(string $label = null)
     * @method Grid\Column|Collection default_lever(string $label = null)
     * @method Grid\Column|Collection min_qty(string $label = null)
     * @method Grid\Column|Collection max_qty(string $label = null)
     * @method Grid\Column|Collection total_max_qty(string $label = null)
     * @method Grid\Column|Collection buy_spread(string $label = null)
     * @method Grid\Column|Collection sell_spread(string $label = null)
     * @method Grid\Column|Collection settle_spread(string $label = null)
     * @method Grid\Column|Collection margin_mode(string $label = null)
     * @method Grid\Column|Collection liquidation_price(string $label = null)
     * @method Grid\Column|Collection hold_position(string $label = null)
     * @method Grid\Column|Collection avail_position(string $label = null)
     * @method Grid\Column|Collection freeze_position(string $label = null)
     * @method Grid\Column|Collection position_margin(string $label = null)
     * @method Grid\Column|Collection settlement_price(string $label = null)
     * @method Grid\Column|Collection maintain_margin_rate(string $label = null)
     * @method Grid\Column|Collection settled_pnl(string $label = null)
     * @method Grid\Column|Collection realized_pnl(string $label = null)
     * @method Grid\Column|Collection unrealized_pnl(string $label = null)
     * @method Grid\Column|Collection bg_img(string $label = null)
     * @method Grid\Column|Collection text_img(string $label = null)
     * @method Grid\Column|Collection peri_img(string $label = null)
     * @method Grid\Column|Collection position_side(string $label = null)
     * @method Grid\Column|Collection current_price(string $label = null)
     * @method Grid\Column|Collection sl_price(string $label = null)
     * @method Grid\Column|Collection sl_trigger_price(string $label = null)
     * @method Grid\Column|Collection sl_trigger_type(string $label = null)
     * @method Grid\Column|Collection tp_price(string $label = null)
     * @method Grid\Column|Collection tp_trigger_price(string $label = null)
     * @method Grid\Column|Collection tp_trigger_type(string $label = null)
     * @method Grid\Column|Collection open_position_price(string $label = null)
     * @method Grid\Column|Collection close_position_price(string $label = null)
     * @method Grid\Column|Collection loss(string $label = null)
     * @method Grid\Column|Collection code(string $label = null)
     * @method Grid\Column|Collection en_name(string $label = null)
     * @method Grid\Column|Collection Symbol(string $label = null)
     * @method Grid\Column|Collection Date(string $label = null)
     * @method Grid\Column|Collection Name(string $label = null)
     * @method Grid\Column|Collection Open(string $label = null)
     * @method Grid\Column|Collection High(string $label = null)
     * @method Grid\Column|Collection Low(string $label = null)
     * @method Grid\Column|Collection Close(string $label = null)
     * @method Grid\Column|Collection LastClose(string $label = null)
     * @method Grid\Column|Collection Price2(string $label = null)
     * @method Grid\Column|Collection Price3(string $label = null)
     * @method Grid\Column|Collection Open_Int(string $label = null)
     * @method Grid\Column|Collection Volume(string $label = null)
     * @method Grid\Column|Collection Amount(string $label = null)
     * @method Grid\Column|Collection is_1min(string $label = null)
     * @method Grid\Column|Collection is_5min(string $label = null)
     * @method Grid\Column|Collection is_15min(string $label = null)
     * @method Grid\Column|Collection is_30min(string $label = null)
     * @method Grid\Column|Collection is_1h(string $label = null)
     * @method Grid\Column|Collection is_2h(string $label = null)
     * @method Grid\Column|Collection is_4h(string $label = null)
     * @method Grid\Column|Collection is_6h(string $label = null)
     * @method Grid\Column|Collection is_12h(string $label = null)
     * @method Grid\Column|Collection is_day(string $label = null)
     * @method Grid\Column|Collection is_week(string $label = null)
     * @method Grid\Column|Collection is_month(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection quote_coin_name(string $label = null)
     * @method Grid\Column|Collection base_coin_name(string $label = null)
     * @method Grid\Column|Collection min_total(string $label = null)
     * @method Grid\Column|Collection trigger_price_buy_rate(string $label = null)
     * @method Grid\Column|Collection trigger_price_sell_rate(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection is_market(string $label = null)
     * @method Grid\Column|Collection up_or_down(string $label = null)
     * @method Grid\Column|Collection start_time(string $label = null)
     * @method Grid\Column|Collection end_time(string $label = null)
     * @method Grid\Column|Collection order_amount(string $label = null)
     * @method Grid\Column|Collection bid_place_threshold(string $label = null)
     * @method Grid\Column|Collection ask_place_threshold(string $label = null)
     * @method Grid\Column|Collection attempts(string $label = null)
     * @method Grid\Column|Collection reserved_at(string $label = null)
     * @method Grid\Column|Collection available_at(string $label = null)
     * @method Grid\Column|Collection img(string $label = null)
     * @method Grid\Column|Collection link_type(string $label = null)
     * @method Grid\Column|Collection link_data(string $label = null)
     * @method Grid\Column|Collection desc(string $label = null)
     * @method Grid\Column|Collection n_id(string $label = null)
     * @method Grid\Column|Collection notifiable_type(string $label = null)
     * @method Grid\Column|Collection notifiable_id(string $label = null)
     * @method Grid\Column|Collection data(string $label = null)
     * @method Grid\Column|Collection read_at(string $label = null)
     * @method Grid\Column|Collection is_bet(string $label = null)
     * @method Grid\Column|Collection scene_id(string $label = null)
     * @method Grid\Column|Collection scene_sn(string $label = null)
     * @method Grid\Column|Collection time_id(string $label = null)
     * @method Grid\Column|Collection seconds(string $label = null)
     * @method Grid\Column|Collection pair_time_name(string $label = null)
     * @method Grid\Column|Collection up_odds(string $label = null)
     * @method Grid\Column|Collection down_odds(string $label = null)
     * @method Grid\Column|Collection draw_odds(string $label = null)
     * @method Grid\Column|Collection begin_time(string $label = null)
     * @method Grid\Column|Collection begin_price(string $label = null)
     * @method Grid\Column|Collection end_price(string $label = null)
     * @method Grid\Column|Collection delivery_up_down(string $label = null)
     * @method Grid\Column|Collection delivery_range(string $label = null)
     * @method Grid\Column|Collection time_name(string $label = null)
     * @method Grid\Column|Collection bet_coin_id(string $label = null)
     * @method Grid\Column|Collection odds_uuid(string $label = null)
     * @method Grid\Column|Collection fee_rate(string $label = null)
     * @method Grid\Column|Collection odds_up_range(string $label = null)
     * @method Grid\Column|Collection odds_down_range(string $label = null)
     * @method Grid\Column|Collection odds_draw_range(string $label = null)
     * @method Grid\Column|Collection describe(string $label = null)
     * @method Grid\Column|Collection image(string $label = null)
     * @method Grid\Column|Collection limit_amount(string $label = null)
     * @method Grid\Column|Collection max_register_time(string $label = null)
     * @method Grid\Column|Collection max_register_num(string $label = null)
     * @method Grid\Column|Collection order_sn(string $label = null)
     * @method Grid\Column|Collection min_num(string $label = null)
     * @method Grid\Column|Collection max_num(string $label = null)
     * @method Grid\Column|Collection note(string $label = null)
     * @method Grid\Column|Collection pay_type(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection cur_amount(string $label = null)
     * @method Grid\Column|Collection lock_amount(string $label = null)
     * @method Grid\Column|Collection order_count(string $label = null)
     * @method Grid\Column|Collection deal_count(string $label = null)
     * @method Grid\Column|Collection deal_rate(string $label = null)
     * @method Grid\Column|Collection overed_at(string $label = null)
     * @method Grid\Column|Collection trans_type(string $label = null)
     * @method Grid\Column|Collection other_uid(string $label = null)
     * @method Grid\Column|Collection entrust_id(string $label = null)
     * @method Grid\Column|Collection order_time(string $label = null)
     * @method Grid\Column|Collection pay_time(string $label = null)
     * @method Grid\Column|Collection deal_time(string $label = null)
     * @method Grid\Column|Collection appeal_status(string $label = null)
     * @method Grid\Column|Collection appeal_time(string $label = null)
     * @method Grid\Column|Collection paid_img(string $label = null)
     * @method Grid\Column|Collection aid(string $label = null)
     * @method Grid\Column|Collection subscribe_performance(string $label = null)
     * @method Grid\Column|Collection contract_performance(string $label = null)
     * @method Grid\Column|Collection option_performance(string $label = null)
     * @method Grid\Column|Collection subscribe_rebate_rate(string $label = null)
     * @method Grid\Column|Collection contract_rebate_rate(string $label = null)
     * @method Grid\Column|Collection option_rebate_rate(string $label = null)
     * @method Grid\Column|Collection subscribe_rebate(string $label = null)
     * @method Grid\Column|Collection contract_rebate(string $label = null)
     * @method Grid\Column|Collection option_rebate(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection uid(string $label = null)
     * @method Grid\Column|Collection num(string $label = null)
     * @method Grid\Column|Collection params(string $label = null)
     * @method Grid\Column|Collection lang(string $label = null)
     * @method Grid\Column|Collection json_content(string $label = null)
     * @method Grid\Column|Collection file(string $label = null)
     * @method Grid\Column|Collection rebate_rate(string $label = null)
     * @method Grid\Column|Collection rebate_rate_exchange(string $label = null)
     * @method Grid\Column|Collection rebate_rate_subscribe(string $label = null)
     * @method Grid\Column|Collection rebate_rate_contract(string $label = null)
     * @method Grid\Column|Collection rebate_rate_option(string $label = null)
     * @method Grid\Column|Collection open_time(string $label = null)
     * @method Grid\Column|Collection country_id(string $label = null)
     * @method Grid\Column|Collection id_card(string $label = null)
     * @method Grid\Column|Collection birthday(string $label = null)
     * @method Grid\Column|Collection city(string $label = null)
     * @method Grid\Column|Collection postal_code(string $label = null)
     * @method Grid\Column|Collection extra(string $label = null)
     * @method Grid\Column|Collection front_img(string $label = null)
     * @method Grid\Column|Collection back_img(string $label = null)
     * @method Grid\Column|Collection hand_img(string $label = null)
     * @method Grid\Column|Collection check_time(string $label = null)
     * @method Grid\Column|Collection primary_status(string $label = null)
     * @method Grid\Column|Collection grade_id(string $label = null)
     * @method Grid\Column|Collection grade_name(string $label = null)
     * @method Grid\Column|Collection grade_name_en(string $label = null)
     * @method Grid\Column|Collection grade_name_tw(string $label = null)
     * @method Grid\Column|Collection grade_img(string $label = null)
     * @method Grid\Column|Collection ug_self_vol(string $label = null)
     * @method Grid\Column|Collection ug_recommend_grade(string $label = null)
     * @method Grid\Column|Collection ug_recommend_num(string $label = null)
     * @method Grid\Column|Collection ug_total_vol(string $label = null)
     * @method Grid\Column|Collection ug_direct_vol(string $label = null)
     * @method Grid\Column|Collection ug_direct_vol_num(string $label = null)
     * @method Grid\Column|Collection ug_direct_recharge(string $label = null)
     * @method Grid\Column|Collection ug_direct_recharge_num(string $label = null)
     * @method Grid\Column|Collection bonus(string $label = null)
     * @method Grid\Column|Collection login_time(string $label = null)
     * @method Grid\Column|Collection login_ip(string $label = null)
     * @method Grid\Column|Collection login_site(string $label = null)
     * @method Grid\Column|Collection login_type(string $label = null)
     * @method Grid\Column|Collection bank_name(string $label = null)
     * @method Grid\Column|Collection real_name(string $label = null)
     * @method Grid\Column|Collection card_no(string $label = null)
     * @method Grid\Column|Collection open_bank(string $label = null)
     * @method Grid\Column|Collection code_img(string $label = null)
     * @method Grid\Column|Collection issue_price(string $label = null)
     * @method Grid\Column|Collection subscribe_currency(string $label = null)
     * @method Grid\Column|Collection expected_time_online(string $label = null)
     * @method Grid\Column|Collection start_subscription_time(string $label = null)
     * @method Grid\Column|Collection end_subscription_time(string $label = null)
     * @method Grid\Column|Collection announce_time(string $label = null)
     * @method Grid\Column|Collection project_details(string $label = null)
     * @method Grid\Column|Collection en_project_details(string $label = null)
     * @method Grid\Column|Collection maximum_purchase(string $label = null)
     * @method Grid\Column|Collection minimum_purchase(string $label = null)
     * @method Grid\Column|Collection en_direction_out(string $label = null)
     * @method Grid\Column|Collection en_direction_in(string $label = null)
     * @method Grid\Column|Collection tw_direction_out(string $label = null)
     * @method Grid\Column|Collection tw_direction_in(string $label = null)
     * @method Grid\Column|Collection user_old_grade(string $label = null)
     * @method Grid\Column|Collection user_new_grade(string $label = null)
     * @method Grid\Column|Collection wallet_id(string $label = null)
     * @method Grid\Column|Collection omni_wallet_address(string $label = null)
     * @method Grid\Column|Collection trx_wallet_address(string $label = null)
     * @method Grid\Column|Collection wallet_address(string $label = null)
     * @method Grid\Column|Collection raw_data(string $label = null)
     * @method Grid\Column|Collection s_user_id(string $label = null)
     * @method Grid\Column|Collection sub_account(string $label = null)
     * @method Grid\Column|Collection logable_id(string $label = null)
     * @method Grid\Column|Collection logable_type(string $label = null)
     * @method Grid\Column|Collection txid(string $label = null)
     * @method Grid\Column|Collection address_type(string $label = null)
     * @method Grid\Column|Collection total_amount(string $label = null)
     * @method Grid\Column|Collection address_note(string $label = null)
     * @method Grid\Column|Collection hash(string $label = null)
     * @method Grid\Column|Collection referrer(string $label = null)
     * @method Grid\Column|Collection phone_status(string $label = null)
     * @method Grid\Column|Collection email_status(string $label = null)
     * @method Grid\Column|Collection google_token(string $label = null)
     * @method Grid\Column|Collection google_status(string $label = null)
     * @method Grid\Column|Collection second_verify(string $label = null)
     * @method Grid\Column|Collection purchase_code(string $label = null)
     * @method Grid\Column|Collection is_agency(string $label = null)
     * @method Grid\Column|Collection is_system(string $label = null)
     * @method Grid\Column|Collection contract_deal(string $label = null)
     * @method Grid\Column|Collection trade_verify(string $label = null)
     * @method Grid\Column|Collection contract_anomaly(string $label = null)
     * @method Grid\Column|Collection from(string $label = null)
     * @method Grid\Column|Collection to(string $label = null)
     * @method Grid\Column|Collection ispb(string $label = null)
     * @method Grid\Column|Collection code_number(string $label = null)
     * @method Grid\Column|Collection nome_extenso(string $label = null)
     * @method Grid\Column|Collection createtime(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection username
     * @property Show\Field|Collection name
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection deep
     * @property Show\Field|Collection password
     * @property Show\Field|Collection payword
     * @property Show\Field|Collection invite_code
     * @property Show\Field|Collection account
     * @property Show\Field|Collection account_type
     * @property Show\Field|Collection pid
     * @property Show\Field|Collection country_code
     * @property Show\Field|Collection user_grade
     * @property Show\Field|Collection user_identity
     * @property Show\Field|Collection user_auth_level
     * @property Show\Field|Collection login_code
     * @property Show\Field|Collection status
     * @property Show\Field|Collection reg_ip
     * @property Show\Field|Collection last_login_time
     * @property Show\Field|Collection last_login_ip
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection trade_status
     * @property Show\Field|Collection email
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection id
     * @property Show\Field|Collection coin_id
     * @property Show\Field|Collection coin_name
     * @property Show\Field|Collection collection_wallet
     * @property Show\Field|Collection datetime
     * @property Show\Field|Collection address
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection agent_level
     * @property Show\Field|Collection agent_name
     * @property Show\Field|Collection draw_out_direction
     * @property Show\Field|Collection into_direction
     * @property Show\Field|Collection usable_balance
     * @property Show\Field|Collection freeze_balance
     * @property Show\Field|Collection log_type
     * @property Show\Field|Collection rich_type
     * @property Show\Field|Collection log_note
     * @property Show\Field|Collection before_balance
     * @property Show\Field|Collection after_balance
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection bet_amount
     * @property Show\Field|Collection bet_coin_name
     * @property Show\Field|Collection odds
     * @property Show\Field|Collection range
     * @property Show\Field|Collection fee
     * @property Show\Field|Collection delivery_amount
     * @property Show\Field|Collection delivery_time
     * @property Show\Field|Collection order_no
     * @property Show\Field|Collection up_down
     * @property Show\Field|Collection symbol
     * @property Show\Field|Collection type
     * @property Show\Field|Collection entrust_price
     * @property Show\Field|Collection trigger_price
     * @property Show\Field|Collection quote_coin_id
     * @property Show\Field|Collection base_coin_id
     * @property Show\Field|Collection traded_amount
     * @property Show\Field|Collection money
     * @property Show\Field|Collection traded_money
     * @property Show\Field|Collection entrust_type
     * @property Show\Field|Collection cancel_time
     * @property Show\Field|Collection hang_status
     * @property Show\Field|Collection buy_order_no
     * @property Show\Field|Collection sell_order_no
     * @property Show\Field|Collection unit_price
     * @property Show\Field|Collection trade_amount
     * @property Show\Field|Collection trade_money
     * @property Show\Field|Collection trade_buy_fee
     * @property Show\Field|Collection trade_sell_fee
     * @property Show\Field|Collection buy_id
     * @property Show\Field|Collection sell_id
     * @property Show\Field|Collection buy_user_id
     * @property Show\Field|Collection sell_user_id
     * @property Show\Field|Collection trade_fee
     * @property Show\Field|Collection payment_amount
     * @property Show\Field|Collection payment_currency
     * @property Show\Field|Collection subscription_time
     * @property Show\Field|Collection subscription_currency_name
     * @property Show\Field|Collection subscription_currency_amount
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection user_password_hash
     * @property Show\Field|Collection new_password
     * @property Show\Field|Collection operation_time
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection module
     * @property Show\Field|Collection key
     * @property Show\Field|Collection value
     * @property Show\Field|Collection tips
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection locale
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection realname
     * @property Show\Field|Collection contents
     * @property Show\Field|Collection imgs
     * @property Show\Field|Collection is_process
     * @property Show\Field|Collection process_note
     * @property Show\Field|Collection process_time
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection client_type
     * @property Show\Field|Collection is_must
     * @property Show\Field|Collection update_log
     * @property Show\Field|Collection url
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection article_id
     * @property Show\Field|Collection body
     * @property Show\Field|Collection excerpt
     * @property Show\Field|Collection admin_user_id
     * @property Show\Field|Collection view_count
     * @property Show\Field|Collection cover
     * @property Show\Field|Collection is_recommend
     * @property Show\Field|Collection location_type
     * @property Show\Field|Collection tourl
     * @property Show\Field|Collection tourl_type
     * @property Show\Field|Collection b_id
     * @property Show\Field|Collection imgurl
     * @property Show\Field|Collection nation_name
     * @property Show\Field|Collection hand_time
     * @property Show\Field|Collection bonusable_id
     * @property Show\Field|Collection bonusable_type
     * @property Show\Field|Collection center_wallet_id
     * @property Show\Field|Collection center_wallet_name
     * @property Show\Field|Collection center_wallet_account
     * @property Show\Field|Collection center_wallet_address
     * @property Show\Field|Collection center_wallet_password
     * @property Show\Field|Collection center_wallet_balance
     * @property Show\Field|Collection min_amount
     * @property Show\Field|Collection open
     * @property Show\Field|Collection high
     * @property Show\Field|Collection low
     * @property Show\Field|Collection close
     * @property Show\Field|Collection max_amount
     * @property Show\Field|Collection qty_decimals
     * @property Show\Field|Collection price_decimals
     * @property Show\Field|Collection full_name
     * @property Show\Field|Collection withdrawal_fee
     * @property Show\Field|Collection withdrawal_min
     * @property Show\Field|Collection withdrawal_max
     * @property Show\Field|Collection coin_withdraw_message
     * @property Show\Field|Collection coin_recharge_message
     * @property Show\Field|Collection coin_transfer_message
     * @property Show\Field|Collection coin_content
     * @property Show\Field|Collection coin_icon
     * @property Show\Field|Collection appKey
     * @property Show\Field|Collection appSecret
     * @property Show\Field|Collection official_website_link
     * @property Show\Field|Collection white_paper_link
     * @property Show\Field|Collection block_query_link
     * @property Show\Field|Collection publish_time
     * @property Show\Field|Collection total_issuance
     * @property Show\Field|Collection total_circulation
     * @property Show\Field|Collection crowdfunding_price
     * @property Show\Field|Collection is_withdraw
     * @property Show\Field|Collection is_recharge
     * @property Show\Field|Collection can_recharge
     * @property Show\Field|Collection pair_id
     * @property Show\Field|Collection pair_name
     * @property Show\Field|Collection margin_name
     * @property Show\Field|Collection used_balance
     * @property Show\Field|Collection contract_id
     * @property Show\Field|Collection bid_plus_unit
     * @property Show\Field|Collection bid_plus_count
     * @property Show\Field|Collection bid_minus_unit
     * @property Show\Field|Collection bid_minus_count
     * @property Show\Field|Collection ask_plus_unit
     * @property Show\Field|Collection ask_plus_count
     * @property Show\Field|Collection ask_minus_unit
     * @property Show\Field|Collection ask_minus_count
     * @property Show\Field|Collection order_type
     * @property Show\Field|Collection side
     * @property Show\Field|Collection contract_coin_id
     * @property Show\Field|Collection margin_coin_id
     * @property Show\Field|Collection unit_amount
     * @property Show\Field|Collection avg_price
     * @property Show\Field|Collection profit
     * @property Show\Field|Collection settle_profit
     * @property Show\Field|Collection is_wear
     * @property Show\Field|Collection lever_rate
     * @property Show\Field|Collection margin
     * @property Show\Field|Collection ts
     * @property Show\Field|Collection system
     * @property Show\Field|Collection contract_coin_name
     * @property Show\Field|Collection maker_fee_rate
     * @property Show\Field|Collection taker_fee_rate
     * @property Show\Field|Collection lever_rage
     * @property Show\Field|Collection default_lever
     * @property Show\Field|Collection min_qty
     * @property Show\Field|Collection max_qty
     * @property Show\Field|Collection total_max_qty
     * @property Show\Field|Collection buy_spread
     * @property Show\Field|Collection sell_spread
     * @property Show\Field|Collection settle_spread
     * @property Show\Field|Collection margin_mode
     * @property Show\Field|Collection liquidation_price
     * @property Show\Field|Collection hold_position
     * @property Show\Field|Collection avail_position
     * @property Show\Field|Collection freeze_position
     * @property Show\Field|Collection position_margin
     * @property Show\Field|Collection settlement_price
     * @property Show\Field|Collection maintain_margin_rate
     * @property Show\Field|Collection settled_pnl
     * @property Show\Field|Collection realized_pnl
     * @property Show\Field|Collection unrealized_pnl
     * @property Show\Field|Collection bg_img
     * @property Show\Field|Collection text_img
     * @property Show\Field|Collection peri_img
     * @property Show\Field|Collection position_side
     * @property Show\Field|Collection current_price
     * @property Show\Field|Collection sl_price
     * @property Show\Field|Collection sl_trigger_price
     * @property Show\Field|Collection sl_trigger_type
     * @property Show\Field|Collection tp_price
     * @property Show\Field|Collection tp_trigger_price
     * @property Show\Field|Collection tp_trigger_type
     * @property Show\Field|Collection open_position_price
     * @property Show\Field|Collection close_position_price
     * @property Show\Field|Collection loss
     * @property Show\Field|Collection code
     * @property Show\Field|Collection en_name
     * @property Show\Field|Collection Symbol
     * @property Show\Field|Collection Date
     * @property Show\Field|Collection Name
     * @property Show\Field|Collection Open
     * @property Show\Field|Collection High
     * @property Show\Field|Collection Low
     * @property Show\Field|Collection Close
     * @property Show\Field|Collection LastClose
     * @property Show\Field|Collection Price2
     * @property Show\Field|Collection Price3
     * @property Show\Field|Collection Open_Int
     * @property Show\Field|Collection Volume
     * @property Show\Field|Collection Amount
     * @property Show\Field|Collection is_1min
     * @property Show\Field|Collection is_5min
     * @property Show\Field|Collection is_15min
     * @property Show\Field|Collection is_30min
     * @property Show\Field|Collection is_1h
     * @property Show\Field|Collection is_2h
     * @property Show\Field|Collection is_4h
     * @property Show\Field|Collection is_6h
     * @property Show\Field|Collection is_12h
     * @property Show\Field|Collection is_day
     * @property Show\Field|Collection is_week
     * @property Show\Field|Collection is_month
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection quote_coin_name
     * @property Show\Field|Collection base_coin_name
     * @property Show\Field|Collection min_total
     * @property Show\Field|Collection trigger_price_buy_rate
     * @property Show\Field|Collection trigger_price_sell_rate
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection is_market
     * @property Show\Field|Collection up_or_down
     * @property Show\Field|Collection start_time
     * @property Show\Field|Collection end_time
     * @property Show\Field|Collection order_amount
     * @property Show\Field|Collection bid_place_threshold
     * @property Show\Field|Collection ask_place_threshold
     * @property Show\Field|Collection attempts
     * @property Show\Field|Collection reserved_at
     * @property Show\Field|Collection available_at
     * @property Show\Field|Collection img
     * @property Show\Field|Collection link_type
     * @property Show\Field|Collection link_data
     * @property Show\Field|Collection desc
     * @property Show\Field|Collection n_id
     * @property Show\Field|Collection notifiable_type
     * @property Show\Field|Collection notifiable_id
     * @property Show\Field|Collection data
     * @property Show\Field|Collection read_at
     * @property Show\Field|Collection is_bet
     * @property Show\Field|Collection scene_id
     * @property Show\Field|Collection scene_sn
     * @property Show\Field|Collection time_id
     * @property Show\Field|Collection seconds
     * @property Show\Field|Collection pair_time_name
     * @property Show\Field|Collection up_odds
     * @property Show\Field|Collection down_odds
     * @property Show\Field|Collection draw_odds
     * @property Show\Field|Collection begin_time
     * @property Show\Field|Collection begin_price
     * @property Show\Field|Collection end_price
     * @property Show\Field|Collection delivery_up_down
     * @property Show\Field|Collection delivery_range
     * @property Show\Field|Collection time_name
     * @property Show\Field|Collection bet_coin_id
     * @property Show\Field|Collection odds_uuid
     * @property Show\Field|Collection fee_rate
     * @property Show\Field|Collection odds_up_range
     * @property Show\Field|Collection odds_down_range
     * @property Show\Field|Collection odds_draw_range
     * @property Show\Field|Collection describe
     * @property Show\Field|Collection image
     * @property Show\Field|Collection limit_amount
     * @property Show\Field|Collection max_register_time
     * @property Show\Field|Collection max_register_num
     * @property Show\Field|Collection order_sn
     * @property Show\Field|Collection min_num
     * @property Show\Field|Collection max_num
     * @property Show\Field|Collection note
     * @property Show\Field|Collection pay_type
     * @property Show\Field|Collection price
     * @property Show\Field|Collection cur_amount
     * @property Show\Field|Collection lock_amount
     * @property Show\Field|Collection order_count
     * @property Show\Field|Collection deal_count
     * @property Show\Field|Collection deal_rate
     * @property Show\Field|Collection overed_at
     * @property Show\Field|Collection trans_type
     * @property Show\Field|Collection other_uid
     * @property Show\Field|Collection entrust_id
     * @property Show\Field|Collection order_time
     * @property Show\Field|Collection pay_time
     * @property Show\Field|Collection deal_time
     * @property Show\Field|Collection appeal_status
     * @property Show\Field|Collection appeal_time
     * @property Show\Field|Collection paid_img
     * @property Show\Field|Collection aid
     * @property Show\Field|Collection subscribe_performance
     * @property Show\Field|Collection contract_performance
     * @property Show\Field|Collection option_performance
     * @property Show\Field|Collection subscribe_rebate_rate
     * @property Show\Field|Collection contract_rebate_rate
     * @property Show\Field|Collection option_rebate_rate
     * @property Show\Field|Collection subscribe_rebate
     * @property Show\Field|Collection contract_rebate
     * @property Show\Field|Collection option_rebate
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection uid
     * @property Show\Field|Collection num
     * @property Show\Field|Collection params
     * @property Show\Field|Collection lang
     * @property Show\Field|Collection json_content
     * @property Show\Field|Collection file
     * @property Show\Field|Collection rebate_rate
     * @property Show\Field|Collection rebate_rate_exchange
     * @property Show\Field|Collection rebate_rate_subscribe
     * @property Show\Field|Collection rebate_rate_contract
     * @property Show\Field|Collection rebate_rate_option
     * @property Show\Field|Collection open_time
     * @property Show\Field|Collection country_id
     * @property Show\Field|Collection id_card
     * @property Show\Field|Collection birthday
     * @property Show\Field|Collection city
     * @property Show\Field|Collection postal_code
     * @property Show\Field|Collection extra
     * @property Show\Field|Collection front_img
     * @property Show\Field|Collection back_img
     * @property Show\Field|Collection hand_img
     * @property Show\Field|Collection check_time
     * @property Show\Field|Collection primary_status
     * @property Show\Field|Collection grade_id
     * @property Show\Field|Collection grade_name
     * @property Show\Field|Collection grade_name_en
     * @property Show\Field|Collection grade_name_tw
     * @property Show\Field|Collection grade_img
     * @property Show\Field|Collection ug_self_vol
     * @property Show\Field|Collection ug_recommend_grade
     * @property Show\Field|Collection ug_recommend_num
     * @property Show\Field|Collection ug_total_vol
     * @property Show\Field|Collection ug_direct_vol
     * @property Show\Field|Collection ug_direct_vol_num
     * @property Show\Field|Collection ug_direct_recharge
     * @property Show\Field|Collection ug_direct_recharge_num
     * @property Show\Field|Collection bonus
     * @property Show\Field|Collection login_time
     * @property Show\Field|Collection login_ip
     * @property Show\Field|Collection login_site
     * @property Show\Field|Collection login_type
     * @property Show\Field|Collection bank_name
     * @property Show\Field|Collection real_name
     * @property Show\Field|Collection card_no
     * @property Show\Field|Collection open_bank
     * @property Show\Field|Collection code_img
     * @property Show\Field|Collection issue_price
     * @property Show\Field|Collection subscribe_currency
     * @property Show\Field|Collection expected_time_online
     * @property Show\Field|Collection start_subscription_time
     * @property Show\Field|Collection end_subscription_time
     * @property Show\Field|Collection announce_time
     * @property Show\Field|Collection project_details
     * @property Show\Field|Collection en_project_details
     * @property Show\Field|Collection maximum_purchase
     * @property Show\Field|Collection minimum_purchase
     * @property Show\Field|Collection en_direction_out
     * @property Show\Field|Collection en_direction_in
     * @property Show\Field|Collection tw_direction_out
     * @property Show\Field|Collection tw_direction_in
     * @property Show\Field|Collection user_old_grade
     * @property Show\Field|Collection user_new_grade
     * @property Show\Field|Collection wallet_id
     * @property Show\Field|Collection omni_wallet_address
     * @property Show\Field|Collection trx_wallet_address
     * @property Show\Field|Collection wallet_address
     * @property Show\Field|Collection raw_data
     * @property Show\Field|Collection s_user_id
     * @property Show\Field|Collection sub_account
     * @property Show\Field|Collection logable_id
     * @property Show\Field|Collection logable_type
     * @property Show\Field|Collection txid
     * @property Show\Field|Collection address_type
     * @property Show\Field|Collection total_amount
     * @property Show\Field|Collection address_note
     * @property Show\Field|Collection hash
     * @property Show\Field|Collection referrer
     * @property Show\Field|Collection phone_status
     * @property Show\Field|Collection email_status
     * @property Show\Field|Collection google_token
     * @property Show\Field|Collection google_status
     * @property Show\Field|Collection second_verify
     * @property Show\Field|Collection purchase_code
     * @property Show\Field|Collection is_agency
     * @property Show\Field|Collection is_system
     * @property Show\Field|Collection contract_deal
     * @property Show\Field|Collection trade_verify
     * @property Show\Field|Collection contract_anomaly
     * @property Show\Field|Collection from
     * @property Show\Field|Collection to
     * @property Show\Field|Collection ispb
     * @property Show\Field|Collection code_number
     * @property Show\Field|Collection nome_extenso
     * @property Show\Field|Collection createtime
     *
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection deep(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection payword(string $label = null)
     * @method Show\Field|Collection invite_code(string $label = null)
     * @method Show\Field|Collection account(string $label = null)
     * @method Show\Field|Collection account_type(string $label = null)
     * @method Show\Field|Collection pid(string $label = null)
     * @method Show\Field|Collection country_code(string $label = null)
     * @method Show\Field|Collection user_grade(string $label = null)
     * @method Show\Field|Collection user_identity(string $label = null)
     * @method Show\Field|Collection user_auth_level(string $label = null)
     * @method Show\Field|Collection login_code(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection reg_ip(string $label = null)
     * @method Show\Field|Collection last_login_time(string $label = null)
     * @method Show\Field|Collection last_login_ip(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection trade_status(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection coin_id(string $label = null)
     * @method Show\Field|Collection coin_name(string $label = null)
     * @method Show\Field|Collection collection_wallet(string $label = null)
     * @method Show\Field|Collection datetime(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection agent_level(string $label = null)
     * @method Show\Field|Collection agent_name(string $label = null)
     * @method Show\Field|Collection draw_out_direction(string $label = null)
     * @method Show\Field|Collection into_direction(string $label = null)
     * @method Show\Field|Collection usable_balance(string $label = null)
     * @method Show\Field|Collection freeze_balance(string $label = null)
     * @method Show\Field|Collection log_type(string $label = null)
     * @method Show\Field|Collection rich_type(string $label = null)
     * @method Show\Field|Collection log_note(string $label = null)
     * @method Show\Field|Collection before_balance(string $label = null)
     * @method Show\Field|Collection after_balance(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection bet_amount(string $label = null)
     * @method Show\Field|Collection bet_coin_name(string $label = null)
     * @method Show\Field|Collection odds(string $label = null)
     * @method Show\Field|Collection range(string $label = null)
     * @method Show\Field|Collection fee(string $label = null)
     * @method Show\Field|Collection delivery_amount(string $label = null)
     * @method Show\Field|Collection delivery_time(string $label = null)
     * @method Show\Field|Collection order_no(string $label = null)
     * @method Show\Field|Collection up_down(string $label = null)
     * @method Show\Field|Collection symbol(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection entrust_price(string $label = null)
     * @method Show\Field|Collection trigger_price(string $label = null)
     * @method Show\Field|Collection quote_coin_id(string $label = null)
     * @method Show\Field|Collection base_coin_id(string $label = null)
     * @method Show\Field|Collection traded_amount(string $label = null)
     * @method Show\Field|Collection money(string $label = null)
     * @method Show\Field|Collection traded_money(string $label = null)
     * @method Show\Field|Collection entrust_type(string $label = null)
     * @method Show\Field|Collection cancel_time(string $label = null)
     * @method Show\Field|Collection hang_status(string $label = null)
     * @method Show\Field|Collection buy_order_no(string $label = null)
     * @method Show\Field|Collection sell_order_no(string $label = null)
     * @method Show\Field|Collection unit_price(string $label = null)
     * @method Show\Field|Collection trade_amount(string $label = null)
     * @method Show\Field|Collection trade_money(string $label = null)
     * @method Show\Field|Collection trade_buy_fee(string $label = null)
     * @method Show\Field|Collection trade_sell_fee(string $label = null)
     * @method Show\Field|Collection buy_id(string $label = null)
     * @method Show\Field|Collection sell_id(string $label = null)
     * @method Show\Field|Collection buy_user_id(string $label = null)
     * @method Show\Field|Collection sell_user_id(string $label = null)
     * @method Show\Field|Collection trade_fee(string $label = null)
     * @method Show\Field|Collection payment_amount(string $label = null)
     * @method Show\Field|Collection payment_currency(string $label = null)
     * @method Show\Field|Collection subscription_time(string $label = null)
     * @method Show\Field|Collection subscription_currency_name(string $label = null)
     * @method Show\Field|Collection subscription_currency_amount(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection user_password_hash(string $label = null)
     * @method Show\Field|Collection new_password(string $label = null)
     * @method Show\Field|Collection operation_time(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection module(string $label = null)
     * @method Show\Field|Collection key(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection tips(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection locale(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection realname(string $label = null)
     * @method Show\Field|Collection contents(string $label = null)
     * @method Show\Field|Collection imgs(string $label = null)
     * @method Show\Field|Collection is_process(string $label = null)
     * @method Show\Field|Collection process_note(string $label = null)
     * @method Show\Field|Collection process_time(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection client_type(string $label = null)
     * @method Show\Field|Collection is_must(string $label = null)
     * @method Show\Field|Collection update_log(string $label = null)
     * @method Show\Field|Collection url(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection article_id(string $label = null)
     * @method Show\Field|Collection body(string $label = null)
     * @method Show\Field|Collection excerpt(string $label = null)
     * @method Show\Field|Collection admin_user_id(string $label = null)
     * @method Show\Field|Collection view_count(string $label = null)
     * @method Show\Field|Collection cover(string $label = null)
     * @method Show\Field|Collection is_recommend(string $label = null)
     * @method Show\Field|Collection location_type(string $label = null)
     * @method Show\Field|Collection tourl(string $label = null)
     * @method Show\Field|Collection tourl_type(string $label = null)
     * @method Show\Field|Collection b_id(string $label = null)
     * @method Show\Field|Collection imgurl(string $label = null)
     * @method Show\Field|Collection nation_name(string $label = null)
     * @method Show\Field|Collection hand_time(string $label = null)
     * @method Show\Field|Collection bonusable_id(string $label = null)
     * @method Show\Field|Collection bonusable_type(string $label = null)
     * @method Show\Field|Collection center_wallet_id(string $label = null)
     * @method Show\Field|Collection center_wallet_name(string $label = null)
     * @method Show\Field|Collection center_wallet_account(string $label = null)
     * @method Show\Field|Collection center_wallet_address(string $label = null)
     * @method Show\Field|Collection center_wallet_password(string $label = null)
     * @method Show\Field|Collection center_wallet_balance(string $label = null)
     * @method Show\Field|Collection min_amount(string $label = null)
     * @method Show\Field|Collection open(string $label = null)
     * @method Show\Field|Collection high(string $label = null)
     * @method Show\Field|Collection low(string $label = null)
     * @method Show\Field|Collection close(string $label = null)
     * @method Show\Field|Collection max_amount(string $label = null)
     * @method Show\Field|Collection qty_decimals(string $label = null)
     * @method Show\Field|Collection price_decimals(string $label = null)
     * @method Show\Field|Collection full_name(string $label = null)
     * @method Show\Field|Collection withdrawal_fee(string $label = null)
     * @method Show\Field|Collection withdrawal_min(string $label = null)
     * @method Show\Field|Collection withdrawal_max(string $label = null)
     * @method Show\Field|Collection coin_withdraw_message(string $label = null)
     * @method Show\Field|Collection coin_recharge_message(string $label = null)
     * @method Show\Field|Collection coin_transfer_message(string $label = null)
     * @method Show\Field|Collection coin_content(string $label = null)
     * @method Show\Field|Collection coin_icon(string $label = null)
     * @method Show\Field|Collection appKey(string $label = null)
     * @method Show\Field|Collection appSecret(string $label = null)
     * @method Show\Field|Collection official_website_link(string $label = null)
     * @method Show\Field|Collection white_paper_link(string $label = null)
     * @method Show\Field|Collection block_query_link(string $label = null)
     * @method Show\Field|Collection publish_time(string $label = null)
     * @method Show\Field|Collection total_issuance(string $label = null)
     * @method Show\Field|Collection total_circulation(string $label = null)
     * @method Show\Field|Collection crowdfunding_price(string $label = null)
     * @method Show\Field|Collection is_withdraw(string $label = null)
     * @method Show\Field|Collection is_recharge(string $label = null)
     * @method Show\Field|Collection can_recharge(string $label = null)
     * @method Show\Field|Collection pair_id(string $label = null)
     * @method Show\Field|Collection pair_name(string $label = null)
     * @method Show\Field|Collection margin_name(string $label = null)
     * @method Show\Field|Collection used_balance(string $label = null)
     * @method Show\Field|Collection contract_id(string $label = null)
     * @method Show\Field|Collection bid_plus_unit(string $label = null)
     * @method Show\Field|Collection bid_plus_count(string $label = null)
     * @method Show\Field|Collection bid_minus_unit(string $label = null)
     * @method Show\Field|Collection bid_minus_count(string $label = null)
     * @method Show\Field|Collection ask_plus_unit(string $label = null)
     * @method Show\Field|Collection ask_plus_count(string $label = null)
     * @method Show\Field|Collection ask_minus_unit(string $label = null)
     * @method Show\Field|Collection ask_minus_count(string $label = null)
     * @method Show\Field|Collection order_type(string $label = null)
     * @method Show\Field|Collection side(string $label = null)
     * @method Show\Field|Collection contract_coin_id(string $label = null)
     * @method Show\Field|Collection margin_coin_id(string $label = null)
     * @method Show\Field|Collection unit_amount(string $label = null)
     * @method Show\Field|Collection avg_price(string $label = null)
     * @method Show\Field|Collection profit(string $label = null)
     * @method Show\Field|Collection settle_profit(string $label = null)
     * @method Show\Field|Collection is_wear(string $label = null)
     * @method Show\Field|Collection lever_rate(string $label = null)
     * @method Show\Field|Collection margin(string $label = null)
     * @method Show\Field|Collection ts(string $label = null)
     * @method Show\Field|Collection system(string $label = null)
     * @method Show\Field|Collection contract_coin_name(string $label = null)
     * @method Show\Field|Collection maker_fee_rate(string $label = null)
     * @method Show\Field|Collection taker_fee_rate(string $label = null)
     * @method Show\Field|Collection lever_rage(string $label = null)
     * @method Show\Field|Collection default_lever(string $label = null)
     * @method Show\Field|Collection min_qty(string $label = null)
     * @method Show\Field|Collection max_qty(string $label = null)
     * @method Show\Field|Collection total_max_qty(string $label = null)
     * @method Show\Field|Collection buy_spread(string $label = null)
     * @method Show\Field|Collection sell_spread(string $label = null)
     * @method Show\Field|Collection settle_spread(string $label = null)
     * @method Show\Field|Collection margin_mode(string $label = null)
     * @method Show\Field|Collection liquidation_price(string $label = null)
     * @method Show\Field|Collection hold_position(string $label = null)
     * @method Show\Field|Collection avail_position(string $label = null)
     * @method Show\Field|Collection freeze_position(string $label = null)
     * @method Show\Field|Collection position_margin(string $label = null)
     * @method Show\Field|Collection settlement_price(string $label = null)
     * @method Show\Field|Collection maintain_margin_rate(string $label = null)
     * @method Show\Field|Collection settled_pnl(string $label = null)
     * @method Show\Field|Collection realized_pnl(string $label = null)
     * @method Show\Field|Collection unrealized_pnl(string $label = null)
     * @method Show\Field|Collection bg_img(string $label = null)
     * @method Show\Field|Collection text_img(string $label = null)
     * @method Show\Field|Collection peri_img(string $label = null)
     * @method Show\Field|Collection position_side(string $label = null)
     * @method Show\Field|Collection current_price(string $label = null)
     * @method Show\Field|Collection sl_price(string $label = null)
     * @method Show\Field|Collection sl_trigger_price(string $label = null)
     * @method Show\Field|Collection sl_trigger_type(string $label = null)
     * @method Show\Field|Collection tp_price(string $label = null)
     * @method Show\Field|Collection tp_trigger_price(string $label = null)
     * @method Show\Field|Collection tp_trigger_type(string $label = null)
     * @method Show\Field|Collection open_position_price(string $label = null)
     * @method Show\Field|Collection close_position_price(string $label = null)
     * @method Show\Field|Collection loss(string $label = null)
     * @method Show\Field|Collection code(string $label = null)
     * @method Show\Field|Collection en_name(string $label = null)
     * @method Show\Field|Collection Symbol(string $label = null)
     * @method Show\Field|Collection Date(string $label = null)
     * @method Show\Field|Collection Name(string $label = null)
     * @method Show\Field|Collection Open(string $label = null)
     * @method Show\Field|Collection High(string $label = null)
     * @method Show\Field|Collection Low(string $label = null)
     * @method Show\Field|Collection Close(string $label = null)
     * @method Show\Field|Collection LastClose(string $label = null)
     * @method Show\Field|Collection Price2(string $label = null)
     * @method Show\Field|Collection Price3(string $label = null)
     * @method Show\Field|Collection Open_Int(string $label = null)
     * @method Show\Field|Collection Volume(string $label = null)
     * @method Show\Field|Collection Amount(string $label = null)
     * @method Show\Field|Collection is_1min(string $label = null)
     * @method Show\Field|Collection is_5min(string $label = null)
     * @method Show\Field|Collection is_15min(string $label = null)
     * @method Show\Field|Collection is_30min(string $label = null)
     * @method Show\Field|Collection is_1h(string $label = null)
     * @method Show\Field|Collection is_2h(string $label = null)
     * @method Show\Field|Collection is_4h(string $label = null)
     * @method Show\Field|Collection is_6h(string $label = null)
     * @method Show\Field|Collection is_12h(string $label = null)
     * @method Show\Field|Collection is_day(string $label = null)
     * @method Show\Field|Collection is_week(string $label = null)
     * @method Show\Field|Collection is_month(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection quote_coin_name(string $label = null)
     * @method Show\Field|Collection base_coin_name(string $label = null)
     * @method Show\Field|Collection min_total(string $label = null)
     * @method Show\Field|Collection trigger_price_buy_rate(string $label = null)
     * @method Show\Field|Collection trigger_price_sell_rate(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection is_market(string $label = null)
     * @method Show\Field|Collection up_or_down(string $label = null)
     * @method Show\Field|Collection start_time(string $label = null)
     * @method Show\Field|Collection end_time(string $label = null)
     * @method Show\Field|Collection order_amount(string $label = null)
     * @method Show\Field|Collection bid_place_threshold(string $label = null)
     * @method Show\Field|Collection ask_place_threshold(string $label = null)
     * @method Show\Field|Collection attempts(string $label = null)
     * @method Show\Field|Collection reserved_at(string $label = null)
     * @method Show\Field|Collection available_at(string $label = null)
     * @method Show\Field|Collection img(string $label = null)
     * @method Show\Field|Collection link_type(string $label = null)
     * @method Show\Field|Collection link_data(string $label = null)
     * @method Show\Field|Collection desc(string $label = null)
     * @method Show\Field|Collection n_id(string $label = null)
     * @method Show\Field|Collection notifiable_type(string $label = null)
     * @method Show\Field|Collection notifiable_id(string $label = null)
     * @method Show\Field|Collection data(string $label = null)
     * @method Show\Field|Collection read_at(string $label = null)
     * @method Show\Field|Collection is_bet(string $label = null)
     * @method Show\Field|Collection scene_id(string $label = null)
     * @method Show\Field|Collection scene_sn(string $label = null)
     * @method Show\Field|Collection time_id(string $label = null)
     * @method Show\Field|Collection seconds(string $label = null)
     * @method Show\Field|Collection pair_time_name(string $label = null)
     * @method Show\Field|Collection up_odds(string $label = null)
     * @method Show\Field|Collection down_odds(string $label = null)
     * @method Show\Field|Collection draw_odds(string $label = null)
     * @method Show\Field|Collection begin_time(string $label = null)
     * @method Show\Field|Collection begin_price(string $label = null)
     * @method Show\Field|Collection end_price(string $label = null)
     * @method Show\Field|Collection delivery_up_down(string $label = null)
     * @method Show\Field|Collection delivery_range(string $label = null)
     * @method Show\Field|Collection time_name(string $label = null)
     * @method Show\Field|Collection bet_coin_id(string $label = null)
     * @method Show\Field|Collection odds_uuid(string $label = null)
     * @method Show\Field|Collection fee_rate(string $label = null)
     * @method Show\Field|Collection odds_up_range(string $label = null)
     * @method Show\Field|Collection odds_down_range(string $label = null)
     * @method Show\Field|Collection odds_draw_range(string $label = null)
     * @method Show\Field|Collection describe(string $label = null)
     * @method Show\Field|Collection image(string $label = null)
     * @method Show\Field|Collection limit_amount(string $label = null)
     * @method Show\Field|Collection max_register_time(string $label = null)
     * @method Show\Field|Collection max_register_num(string $label = null)
     * @method Show\Field|Collection order_sn(string $label = null)
     * @method Show\Field|Collection min_num(string $label = null)
     * @method Show\Field|Collection max_num(string $label = null)
     * @method Show\Field|Collection note(string $label = null)
     * @method Show\Field|Collection pay_type(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection cur_amount(string $label = null)
     * @method Show\Field|Collection lock_amount(string $label = null)
     * @method Show\Field|Collection order_count(string $label = null)
     * @method Show\Field|Collection deal_count(string $label = null)
     * @method Show\Field|Collection deal_rate(string $label = null)
     * @method Show\Field|Collection overed_at(string $label = null)
     * @method Show\Field|Collection trans_type(string $label = null)
     * @method Show\Field|Collection other_uid(string $label = null)
     * @method Show\Field|Collection entrust_id(string $label = null)
     * @method Show\Field|Collection order_time(string $label = null)
     * @method Show\Field|Collection pay_time(string $label = null)
     * @method Show\Field|Collection deal_time(string $label = null)
     * @method Show\Field|Collection appeal_status(string $label = null)
     * @method Show\Field|Collection appeal_time(string $label = null)
     * @method Show\Field|Collection paid_img(string $label = null)
     * @method Show\Field|Collection aid(string $label = null)
     * @method Show\Field|Collection subscribe_performance(string $label = null)
     * @method Show\Field|Collection contract_performance(string $label = null)
     * @method Show\Field|Collection option_performance(string $label = null)
     * @method Show\Field|Collection subscribe_rebate_rate(string $label = null)
     * @method Show\Field|Collection contract_rebate_rate(string $label = null)
     * @method Show\Field|Collection option_rebate_rate(string $label = null)
     * @method Show\Field|Collection subscribe_rebate(string $label = null)
     * @method Show\Field|Collection contract_rebate(string $label = null)
     * @method Show\Field|Collection option_rebate(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection uid(string $label = null)
     * @method Show\Field|Collection num(string $label = null)
     * @method Show\Field|Collection params(string $label = null)
     * @method Show\Field|Collection lang(string $label = null)
     * @method Show\Field|Collection json_content(string $label = null)
     * @method Show\Field|Collection file(string $label = null)
     * @method Show\Field|Collection rebate_rate(string $label = null)
     * @method Show\Field|Collection rebate_rate_exchange(string $label = null)
     * @method Show\Field|Collection rebate_rate_subscribe(string $label = null)
     * @method Show\Field|Collection rebate_rate_contract(string $label = null)
     * @method Show\Field|Collection rebate_rate_option(string $label = null)
     * @method Show\Field|Collection open_time(string $label = null)
     * @method Show\Field|Collection country_id(string $label = null)
     * @method Show\Field|Collection id_card(string $label = null)
     * @method Show\Field|Collection birthday(string $label = null)
     * @method Show\Field|Collection city(string $label = null)
     * @method Show\Field|Collection postal_code(string $label = null)
     * @method Show\Field|Collection extra(string $label = null)
     * @method Show\Field|Collection front_img(string $label = null)
     * @method Show\Field|Collection back_img(string $label = null)
     * @method Show\Field|Collection hand_img(string $label = null)
     * @method Show\Field|Collection check_time(string $label = null)
     * @method Show\Field|Collection primary_status(string $label = null)
     * @method Show\Field|Collection grade_id(string $label = null)
     * @method Show\Field|Collection grade_name(string $label = null)
     * @method Show\Field|Collection grade_name_en(string $label = null)
     * @method Show\Field|Collection grade_name_tw(string $label = null)
     * @method Show\Field|Collection grade_img(string $label = null)
     * @method Show\Field|Collection ug_self_vol(string $label = null)
     * @method Show\Field|Collection ug_recommend_grade(string $label = null)
     * @method Show\Field|Collection ug_recommend_num(string $label = null)
     * @method Show\Field|Collection ug_total_vol(string $label = null)
     * @method Show\Field|Collection ug_direct_vol(string $label = null)
     * @method Show\Field|Collection ug_direct_vol_num(string $label = null)
     * @method Show\Field|Collection ug_direct_recharge(string $label = null)
     * @method Show\Field|Collection ug_direct_recharge_num(string $label = null)
     * @method Show\Field|Collection bonus(string $label = null)
     * @method Show\Field|Collection login_time(string $label = null)
     * @method Show\Field|Collection login_ip(string $label = null)
     * @method Show\Field|Collection login_site(string $label = null)
     * @method Show\Field|Collection login_type(string $label = null)
     * @method Show\Field|Collection bank_name(string $label = null)
     * @method Show\Field|Collection real_name(string $label = null)
     * @method Show\Field|Collection card_no(string $label = null)
     * @method Show\Field|Collection open_bank(string $label = null)
     * @method Show\Field|Collection code_img(string $label = null)
     * @method Show\Field|Collection issue_price(string $label = null)
     * @method Show\Field|Collection subscribe_currency(string $label = null)
     * @method Show\Field|Collection expected_time_online(string $label = null)
     * @method Show\Field|Collection start_subscription_time(string $label = null)
     * @method Show\Field|Collection end_subscription_time(string $label = null)
     * @method Show\Field|Collection announce_time(string $label = null)
     * @method Show\Field|Collection project_details(string $label = null)
     * @method Show\Field|Collection en_project_details(string $label = null)
     * @method Show\Field|Collection maximum_purchase(string $label = null)
     * @method Show\Field|Collection minimum_purchase(string $label = null)
     * @method Show\Field|Collection en_direction_out(string $label = null)
     * @method Show\Field|Collection en_direction_in(string $label = null)
     * @method Show\Field|Collection tw_direction_out(string $label = null)
     * @method Show\Field|Collection tw_direction_in(string $label = null)
     * @method Show\Field|Collection user_old_grade(string $label = null)
     * @method Show\Field|Collection user_new_grade(string $label = null)
     * @method Show\Field|Collection wallet_id(string $label = null)
     * @method Show\Field|Collection omni_wallet_address(string $label = null)
     * @method Show\Field|Collection trx_wallet_address(string $label = null)
     * @method Show\Field|Collection wallet_address(string $label = null)
     * @method Show\Field|Collection raw_data(string $label = null)
     * @method Show\Field|Collection s_user_id(string $label = null)
     * @method Show\Field|Collection sub_account(string $label = null)
     * @method Show\Field|Collection logable_id(string $label = null)
     * @method Show\Field|Collection logable_type(string $label = null)
     * @method Show\Field|Collection txid(string $label = null)
     * @method Show\Field|Collection address_type(string $label = null)
     * @method Show\Field|Collection total_amount(string $label = null)
     * @method Show\Field|Collection address_note(string $label = null)
     * @method Show\Field|Collection hash(string $label = null)
     * @method Show\Field|Collection referrer(string $label = null)
     * @method Show\Field|Collection phone_status(string $label = null)
     * @method Show\Field|Collection email_status(string $label = null)
     * @method Show\Field|Collection google_token(string $label = null)
     * @method Show\Field|Collection google_status(string $label = null)
     * @method Show\Field|Collection second_verify(string $label = null)
     * @method Show\Field|Collection purchase_code(string $label = null)
     * @method Show\Field|Collection is_agency(string $label = null)
     * @method Show\Field|Collection is_system(string $label = null)
     * @method Show\Field|Collection contract_deal(string $label = null)
     * @method Show\Field|Collection trade_verify(string $label = null)
     * @method Show\Field|Collection contract_anomaly(string $label = null)
     * @method Show\Field|Collection from(string $label = null)
     * @method Show\Field|Collection to(string $label = null)
     * @method Show\Field|Collection ispb(string $label = null)
     * @method Show\Field|Collection code_number(string $label = null)
     * @method Show\Field|Collection nome_extenso(string $label = null)
     * @method Show\Field|Collection createtime(string $label = null)
     */
    class Show {}

    /**
     * @method \App\Extensions\Form\RatePercentage ratePer(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     * @method $this percentage(...$params)
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
