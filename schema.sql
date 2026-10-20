-- Tabela `polls`: guarda as ENQUETES.
--  - id: identificador da enquete
--  - question: texto da pergunta
--  - created_at: quando a enquete foi criada
CREATE TABLE IF NOT EXISTS polls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela `poll_options`: guarda as OPÇÕES de cada enquete.
--  - id: identificador da opção
--  - poll_id: referência à enquete (polls.id)
--  - label: texto da opção
--  - votes: contador de votos da opção
--  * ON DELETE CASCADE: se a enquete for apagada, apaga as opções junto
CREATE TABLE IF NOT EXISTS poll_options (
  id INT AUTO_INCREMENT PRIMARY KEY,
  poll_id INT NOT NULL,
  label VARCHAR(120) NOT NULL,
  votes INT NOT NULL DEFAULT 0,
  FOREIGN KEY (poll_id) REFERENCES polls(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela `settings`: indica qual enquete está ATIVA no site.
--  - id: sempre 1 (registro único)
--  - current_poll_id: id da enquete ativa (polls.id) ou NULL se não houver
--  * ON DELETE SET NULL: se a enquete ativa for removida, volta a NULL
CREATE TABLE IF NOT EXISTS settings (
  id TINYINT PRIMARY KEY DEFAULT 1,
  current_poll_id INT NULL,
  FOREIGN KEY (current_poll_id) REFERENCES polls(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Garante que exista o registro único de settings (id=1)
INSERT INTO settings (id, current_poll_id) VALUES (1, NULL)
  ON DUPLICATE KEY UPDATE current_poll_id = current_poll_id;
