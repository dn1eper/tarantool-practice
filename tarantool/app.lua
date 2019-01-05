#!/usr/bin/env tarantool

httpd = require('http.server').new('127.0.0.1', 8080)

box.cfg{}

-- Создаем пространство для хранения пользователей
if not box.space.users then
    users = box.schema.space.create("users")
    users:create_index('primary', {type = 'TREE', parts = {1, 'NUM'}})
    users:create_index('token', { type = 'TREE', parts = { 2, 'STR'}})
end

-- Добавляем пользователя и токен в пространство
httpd:route({path = '/add/:id/:token', method = 'GET'}, function(req)
    id = self:stash('id')
    token = self:stash('token')
    expires_in = os.time(os.date("!*t")) + 24*3600

    if next(box.space.users:select{id}) == nil then
        -- если нет записи для этого пользователя, то добаляем ее
        box.space.users:insert{id, token, expires_in}
    else
        -- или обновляем токен
        box.space.users:update(id, {{'=', 2, token}, {'=', 3, expires_in}})
    end
    
    return req:render({json = {status = "OK"}})
end)

-- Проверяем наличие токена в хранилище, и не истекло ли его время
httpd:route({path = '/validate/:id/:token', method = 'GET'}, function(req)
    id = self:stash('id')
    token = self:stash('token')
    now = os.time(os.date("!*t"))

    user = box.space.users:select{id, token}
    if next(user) == nil then
        return req:render({json = {status = "Error"}})
    else
        if user[1][3] > now then
            return req:render({json = {status = "Error"}})
        else
            return req:render({json = {status = "OK"}})
        end
    end
end)

-- Запускаем сервер
httpd:start()