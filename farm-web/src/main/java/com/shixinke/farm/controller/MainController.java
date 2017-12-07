package com.shixinke.farm.controller;

import com.shixinke.farm.configuration.BusinessConfiguration;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import java.util.HashMap;
import java.util.Map;

@RequestMapping("/config")
@Controller
/**
 * @author shixinke [ishixinke@qq.com]
 * @date 17-12-6.
 */
public class MainController {

    @Value("${app.env}")
    private String env;

    @Autowired
    private BusinessConfiguration businessConfiguration;

    @GetMapping("/list")
    @ResponseBody
    public Map<String, String> configList() {
        Map<String, String> result = new HashMap<>(10);
        result.put("test", "test");
        result.put("env", env);
        return result;
    }

    @GetMapping("/business/list")
    @ResponseBody
    public Map<String, String> businessList() {
        Map<String, String> result = new HashMap<>(10);
        result.put("appJsVersion", businessConfiguration.getAppJsVersion());
        result.put("appCssVersion", businessConfiguration.getAppCssVersion());
        return result;
    }
}
